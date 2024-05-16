<?php

namespace App\Services;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class UserService
{
    // store user
    public function storeUser(Request $request)
    {
        $user = \App\Models\User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'account_type' => $request->account_type ? $request->account_type : User::INDIVIDUAL
        ]);

        return $user;
    }
}
