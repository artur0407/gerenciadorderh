<?php

namespace App\Http\Controllers;

use App\Models\Department;
use App\Models\User;
use Illuminate\Contracts\View\View;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class DepartmentController
{
    public function index()
    {
        $departments = Department::all();
        
        return view('department.departments', compact('departments'));
    }

    public function newDepartment(): View
    {
        return view('department.add-department');
    }

    public function createDepartment(Request $request)
    {
        // form validation
        $request->validate([
            'name' => 'required|string|min:3|max:50|unique:departments'
        ]);

        Department::create([
            'name' => $request->name
        ]);

        return redirect()->route('departments');
    }

    public function editDepartment($id)
    {
        if ($this->isDepartmentBlocked($id)) {
            return redirect()->route('departments');
        }

        $department = Department::findOrFail($id);

        return view('department.edit-department', compact('department'));
    }

    public function updateDepartment(Request $request)
    {
        $id = $request->id;

        if ($this->isDepartmentBlocked($id)) {
            return redirect()->route('departments');
        }
        
        // form validation
        $request->validate([
            'id' => 'required',
            'name' => 'required|string|min:3|max:50|unique:departments,name,'.$id
        ]);

        $department = Department::findOrFail($id);

        $department->update([
            'name' => $request->name
        ]);

        return redirect()->route('departments');
    }

    public function deleteDepartment($id)
    {
        if ($this->isDepartmentBlocked($id)) {
            return redirect()->route('departments');
        }

        $department = Department::findOrFail($id);

        return view('department.delete-department-confirm', compact('department'));
    }

    public function deleteDepartmentConfirm($id)
    {
        if ($this->isDepartmentBlocked($id)) {
            return redirect()->route('departments');
        }

        $department = Department::findOrFail($id);
        $department->delete();

        // update all colaborators department to null
        User::where('department_id', $id)->update(['department_id' => null]);

        return redirect()->route('departments');
    }

    public function isDepartmentBlocked($id)
    {
        return in_array(intval($id), [1,2]);
    }
}