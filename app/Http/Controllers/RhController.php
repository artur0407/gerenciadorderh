<?php

namespace App\Http\Controllers;

use App\Mail\ConfirmAccountEmail;
use App\Models\Department;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Str;
use Illuminate\Validation\Rule;

class RhController
{
    protected function rules($userId = null): array
    {
        return [
            'name' => 'required|string|max:255',
            'email' => [
                'required',
                'email',
                'max:255',
                Rule::unique('users', 'email')->ignore($userId),
            ],
            'select_department' => 'required|exists:departments,id',
            'address' => 'required|string|max:255',
            'zip_code' => 'required|string|max:10|regex:/^\d{5}-\d{3}$/',
            'city' => 'required|string|max:50',
            'phone' => 'required|string|max:50|regex:/^\(\d{2}\)\s\d{5}-\d{4}$/',
            'salary' => 'required|regex:/^\d{1,3}(\.\d{3})*,\d{2}$/',
            'admission_date' => 'required|date_format:d/m/Y',
        ];
    }

    public function home()
    {
        // collect all information about the organization
        $data = [];

        // get total number of colaborators (deleted_at is null)
        $data['total_colaborators'] = User::whereNotIn('role', ['admin', 'rh'])->whereNull('deleted_at')->count();

        // total colaborators deleted
        $data['total_colaborators_deleted'] = User::whereNotIn('role', ['admin', 'rh'])->onlyTrashed()->count();

        // total salary for all colaborators
        $data['total_salary'] = User::whereNotIn('role', ['admin', 'rh'])->withoutTrashed()
            ->with('detail')
            ->get()->sum(function ($colaborator) {
                return $colaborator->detail->salary;
            });
            
        $data['total_salary'] = number_format($data['total_salary'], 2, ',' , '.'). ' $';

        // total colaborators by department
        $data['total_colaborators_per_department'] = User::whereNotIn('role', ['admin', 'rh'])->withoutTrashed()
            ->with('department')
            ->get()
            ->groupBy('department_id')
            ->map(function ($department) {
                return [
                    'department' => $department->first()->department->name ?? '_',
                    'total' => $department->count()
                ];
            });

        $data['total_salary_by_department'] = User::whereNotIn('role', ['admin', 'rh'])->withoutTrashed()
            ->with('department', 'detail')
            ->get()
            ->groupBy('department_id')
            ->map(function ($department) {
                return [
                    'department' => $department->first()->department->name ?? '_',
                    'total' => $department->sum(function($colaborator) {
                        return $colaborator->detail->salary;
                    })
                ];
            });
        
        // format salary
        $data['total_salary_by_department'] = $data['total_salary_by_department']->map(function($department) {
            return [
                'department' => $department['department'],
                'total' => number_format($department['total'], 2, ',' , '.'). ' $'
            ];
        });

        // display admin home page
        return view('home', compact('data'));
    }

    public function index()
    {
        // $colaborators = User::where('role', 'rh')->get();
        $colaborators = User::withTrashed()
                        ->with('detail')
                        ->where('role', 'rh')
                        ->get();

        return view('users.rh', compact('colaborators'));
    }

    public function newColaborator()
    {
        //get all departments
        $departments = Department::where('id',2)->get();

        return view('users.rh-new', compact('departments'));
    }

    public function createColaborator(Request $request)
    {
        $request->validate($this->rules());

        // check if department d === 2
        if ($request->select_department != 2) {
             return redirect()->route('home');
        }

        // create user confirm token
        $token = Str::random(60);

        // create new rh user
        $user = new User();
        $user->name = $request->name;
        $user->email = $request->email;
        $user->confirmation_token = $token;
        $user->role = 'rh';
        $user->department_id = $request->select_department;
        $user->permissions = '["rh"]';
        $user->save();

        // save user details
        $user->detail()->create([
            'address' => $request->address,
            'zip_code' => $request->zip_code,
            'city' => $request->city,
            'phone' => $request->phone,
            'salary' => $request->salary,
            'admission_date' => $request->admission_date
        ]);

        // send email to user
        Mail::to($user->email)->send(new ConfirmAccountEmail(route('confirm-account', $token)));

        return redirect()->route('users.rh')->with('success', 'Colaborador criado com sucesso!');
    }

    public function editColaborator($id)
    {
        $colaborator = User::with('detail')->where('role', 'rh')->findOrFail($id);
        $departments = Department::where('id', 2)->get();

        return view('users.rh-edit', compact('colaborator', 'departments'));
    }

    public function updateColaborator(Request $request)
    {
        $user = User::with('detail')->findOrFail($request->user_id);
        
        // form validation
        $request->validate($this->rules($user->id));

        $user->name = $request->name;
        $user->email = $request->email;
        $user->detail->address = $request->address;
        $user->detail->zip_code = $request->zip_code;
        $user->detail->city = $request->city;
        $user->detail->phone = $request->phone;
        $user->detail->salary = $request->salary;
        $user->detail->admission_date = $request->admission_date;
        $user->department_id = $request->select_department;

        $user->save();
        $user->detail->save();

        return redirect()->route('users.rh')->with('success', 'Colaborador alterado com sucesso!');
    }

    public function deleteColaborator($id)
    {
        $colaborator = User::findOrFail($id);

        return view('users.rh-delete', compact('colaborator'));
    }

    public function deleteColaboratorConfirm($id)
    {
        $colaborator = User::findOrFail($id);
        $colaborator->delete();

        return redirect()->route('users.rh')->with('success', 'Colaborador deletado com sucesso!');
    }

    public function restoreColaborator($id)
    {
        // get user removed with softDelete
        $colaborator = User::withTrashed()->where('role', 'rh')->findOrFail($id);
        $colaborator->restore();

        return redirect()->route('users.rh')->with('success', 'Colaborador restaurado com sucesso');
    }

    public function showDetails($id)
    {
        $colaborator = User::with('detail', 'department')->findOrFail($id);

        return view('users.show-details', compact('colaborator'));
    }
}
