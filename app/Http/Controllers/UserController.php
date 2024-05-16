<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Services\UserService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    public $userService;

    public function __construct()
    {
        $this->userService = new UserService();
    }

    // create user
    public function createPage()
    {
        return view('users.create');
    }

    //store user
    public function createUser(Request $request)
    {
        $request->validate([
            'name' => 'required',
            'email' => 'required|email|unique:users',
            'password' => 'required|min:8',
            'account_type' => 'nullable'
        ]);

        try {
            $user = $this->userService->storeUser($request);
            return back()->with('status', 'User created successfully');
        } catch (\Exception $e) {
            return back()->with('error', $e->getMessage());
        }
    }
}
