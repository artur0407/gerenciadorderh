<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AdminController
{
    public function home()
    {
        Auth::user()->can('admin') ?: abort(403, 'Você não tem acesso a esta página');

        // display admin home page
        return view('home');
    }
}
