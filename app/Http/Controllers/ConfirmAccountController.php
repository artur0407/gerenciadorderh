<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;

class ConfirmAccountController
{
    public function confirmAccount($token)
    {
        // check if the token is valid
        $user = User::where('confirmation_token', $token)->first();

        if (!$user) {
            abort(403, 'Token inválido');
        }

        return view('auth.confirm-account', compact('user'));
    }

    public function confirmAccountSubmit(Request $request)
    {
        // form validation
        $request->validate([
            'confirmation_token' => 'required|string|size:60',
            'password' => 'required|confirmed|min:8|max:16|regex:/^(?=.*[a-z])(?=.*[A-Z])(?=.*\d).+$/'
        ]);

        $user = User::where('confirmation_token', $request->confirmation_token)->first();
        $user->password = bcrypt($request->password);
        $user->confirmation_token = null;
        $user->email_verified_at = now();
        $user->save();

        return redirect()->route('login');
    }
}
