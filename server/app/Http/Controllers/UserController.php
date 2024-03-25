<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
        return ['users' => User::all()];
    }

    public function user_recipes(User $user) {
        return $user->recipes()->get();
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(User $user)
    {
        //
        return $user;
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    public function update_name_email(Request $request, User $user) {
        $request->validate([
            'name' => 'required',
            'email' => ['required', 'email', 'unique:users']
        ]);

        $user->email = $request->email;
        $user->name = $request->name;
        $user->update();

        return response(['message' => 'Name and email updated successfully', 'user' => $user], 200);

    }

    public function change_password(Request $request) {
        $data = $request->validate([
            'current_password' => 'required',
            'new_password_confirmation' => 'required',
            'new_password' => ['required', 'confirmed', 'min:6']
        ]);
        $auth = Auth::user();
        if(!Hash::check($data['current_password'], $auth->password)) {
            return response(['current_password' => 'Current password is invalid.'], 500);
        }

        if(strcmp($data['current_password'], $data['new_password']) == 0) {
            return response(['new_password' => 'New Password cannot be same as your current password.'], 500);
        }

        $auth->password = Hash::make($request->new_password);
        $auth->save();
        return response(['message' => 'Password successfully changed'], 200);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
