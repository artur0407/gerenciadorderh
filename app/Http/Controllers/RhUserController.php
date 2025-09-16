<?php

namespace App\Http\Controllers;

use App\Models\Department;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class RhUserController
{
    public function index()
    {
        // se for admin não faz nada e o código segue, se não for admin aborta com a mensagem
        Auth::user()->can('admin') ?: abort(403, 'Você não tem autorização para acessar esta página');

        $colaborators = User::where('role', 'rh')->get();

        return view('colaborators.rh-users', compact('colaborators'));
    }

    public function newColaborator()
    {
        // se for admin não faz nada e o código segue, se não for admin aborta com a mensagem
        Auth::user()->can('admin') ?: abort(403, 'Você não tem autorização para acessar esta página');

        //get all departments
        $departments = Department::all();

        return view('colaborators.add-rh-user', compact('departments'));
    }

    public function createColaborator(Request $request)
    {
        // se for admin não faz nada e o código segue, se não for admin aborta com a mensagem
        Auth::user()->can('admin') ?: abort(403, 'Você não tem autorização para acessar esta página');

        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|max:255|unique:users,email',
            'select_department' => 'required|exists:departments,id',
            'address' => 'required|string|max:255',
            'zip_code' => 'required|string|max:10',
            'city' => 'required|string|max:50',
            'phone' => 'required|string|max:50',
            'salary' => 'required|decimal:2',
            'admission_date' => 'required|date_format:Y-m-d'
        ]);

        // check if department d === 2
        if ($request->select_department != 2) {
             return redirect()->route('home');
        }

        // create new rh user
        $user = new User();
        $user->name = $request->name;
        $user->email = $request->email;
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

        return redirect()->route('colaborators.rh')->with('success', 'Colaborador criado com sucesso!');

    }
}
