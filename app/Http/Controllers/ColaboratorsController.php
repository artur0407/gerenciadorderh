<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ColaboratorsController
{
    public function index()
    {
        $colaborators = User::withTrashed()
                        ->with('detail', 'department')
                        ->where('role', '<>', 'admin')
                        ->get();
        
        return view('colaborators.admin-all-colaborators')->with('colaborators', $colaborators);
    }

    public function showDetails($id)
    {
        // check if id is the same as the auth user
        if (Auth::user()->id === $id) {
            return redirect()->route('home');
        }

        $colaborator = User::with('detail', 'department')
                        ->where('id', $id)
                        ->first();
        
        // check if colaborator existis
        if (!$colaborator) {
            abort(404);
        }
        
        return view('colaborators.show-details')->with('colaborator', $colaborator);
    }

    public function deleteColaborator($id)
    {
        // check if id is the same as the auth user
        if (Auth::user()->id === $id) {
            return redirect()->route('home');
        }

        $colaborator = User::findOrFail($id);

        return view('colaborators.delete-colaborator-confirm')->with('colaborator', $colaborator);
    }

    public function deleteColaboratorConfirm($id)
    {
        // check if id is the same as the auth user
        if (Auth::user()->id === $id) {
            return redirect()->route('home');
        }

        $colaborator = User::findOrFail($id);
        $colaborator->delete();

        return redirect()->route('colaborators')->with('success', 'Colaborador deletado com sucesso!');
    }

    public function restoreColaborator($id)
    {
        // get user removed with softDelete
        $colaborator = User::withTrashed()->findOrFail($id);
        $colaborator->restore();

        return redirect()->route('colaborators.rh')->with('success', 'Colaborador restaurado com sucesso');
    }

    public function home()
    {
        // get colaborator data
        $colaborator = User::with('detail', 'department')
                        ->where('id', Auth::user()->id)
                        ->first();

        return view('colaborators.show-details', compact('colaborator'));
    }
}