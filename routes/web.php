<?php

use App\Models\User;
use Illuminate\Support\Facades\Route;

Route::get('/admin', function () {
    $admin = User::with('detail', 'department')->find(1);

   return view('admin', compact('admin'));
});
