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

class RhManagementController
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
            'zip_code' => 'required|string|max:10',
            'city' => 'required|string|max:50',
            'phone' => 'required|string|max:50',
            'salary' => 'required|decimal:2',
            'admission_date' => 'required|date_format:Y-m-d',
        ];
    }

    public function index()
    {
        // get all colaborators that are not role admin and rh
        $colaborators = User::with('detail', 'department')
                        ->where('role', 'colaborator')
                        ->withTrashed()
                        ->get();
        
        return view('users.colaborators', compact('colaborators'));
    }

    public function newColaborator()
    {
        $departments = Department::where('id', '>', 2)->get();

        // if there are no departments, abort the request
        if ($departments->count() === 0)
            abort(403, 'Não há departamentos para adicionar colaboradores. Contate o administrador do sistema');

        return view('users.colaborator-new', compact('departments'));
    }

    public function createColaborator(Request $request)
    {
        $request->validate($this->rules());

        // check if department <= 1 (admin, rh)
        if ($request->select_department <= 2) {
             return redirect()->route('home');
        }

        // create user confirm token
        $token = Str::random(60);

        // create new user
        $user = new User();
        $user->name = $request->name;
        $user->email = $request->email;
        $user->confirmation_token = $token;
        $user->role = 'colaborator';
        $user->department_id = $request->select_department;
        $user->permissions = '["colaborator"]';
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

        return redirect()->route('rh.management.home')->with('success', 'Colaborador criado com sucesso!');
    }

    public function editColaborator($id)
    {
        $colaborator = User::with('detail')->findOrFail($id);
        $departments = Department::where('id', '>', 2)->get();

        return view('users.colaborator-edit', compact('colaborator', 'departments'));
    }

    public function updateColaborator(Request $request)
    {
        $user = User::with('detail')->findOrFail($request->user_id);
        
        // form validation
        $request->validate($this->rules($user->id));

        // check if department is valid
        if ($request->select_department <= 2) {
            return redirect()->route('home');
        }

        $user->name = $request->name;
        $user->email = $request->email;
        $user->detail->address = $request->address;
        $user->detail->zip_code = $request->zip_code;
        $user->detail->city =  $request->city;
        $user->detail->phone =  $request->phone;
        $user->detail->salary = $request->salary;
        $user->detail->admission_date = $request->admission_date;
        $user->department_id = $request->select_department;

        $user->save();
        $user->detail->save();

        return redirect()->route('rh.management.home')->with('success', 'Colaborador alterado com sucesso!');
    }

    public function showDetails($id)
    {
        $colaborator = User::with('detail', 'department')->findOrFail($id);

        return view('users.show-details', compact('colaborator'));
    }

    public function deleteColaborator($id)
    {
        $colaborator = User::findOrFail($id);

        return view('users.colaborator-delete', compact('colaborator'));
    }

    public function deleteColaboratorConfirm($id)
    {
        $colaborator = User::findOrFail($id);
        $colaborator->delete();

        return redirect()->route('users.colaborators')->with('success', 'Colaborador alterado com sucesso!');
    }

    public function restoreColaborator($id)
    {
        $colaborator = User::withTrashed()->findOrFail($id);
        $colaborator->restore();

        return redirect()->route('users.colaborators')->with('success', 'Colaborador restaurado com sucesso!');
    }
}
