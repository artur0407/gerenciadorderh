<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class HomeController
{
    public function index()
    {
        if (auth()->user()->role === 'admin') {
            return redirect()->route('users.admin.home');
        } else if (auth()->user()->role === 'rh') {
            return redirect()->route('users.rh.home');
        } else {
            return redirect()->route('users.colaborators.home');
        }
    }
}
