<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;

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

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
