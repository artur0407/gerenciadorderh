<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class RhManagementController
{
    public function home()
    {
        Auth::user()->can('rh') ?: abort(403, 'Você não tem acesso a esta página');

        // get all colaborators that are not role admin and rh
        $colaborators = User::with('detail', 'department')
                        ->where('role', 'colaborator')
                        ->withTrashed()
                        ->get();
        
        return view('colaborators.colaborators', compact('colaborators'));
    }
}
