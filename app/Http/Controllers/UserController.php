<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;

class UserController extends Controller
{
    // Display all users
    public function index()
    {
        $users = User::orderBy('name')->paginate(15);
        return view('users.index', compact('users'));
    }

    // Show create form
    public function create()
    {
        $roles = ['admin', 'manager', 'employee'];
        return view('users.create', compact('roles'));
    }

    // Store a new user
    public function store(Request $request)
    {
        $data = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email',
            'role' => 'required|in:admin,manager,employee',
            'password' => 'required|confirmed|min:6',
        ]);

        $data['password'] = bcrypt($data['password']);

        User::create($data);

        return redirect()->route('users.index')->with('success', 'User created successfully.');
    }

    // Show edit form
    public function edit(User $user)
    {
        $roles = ['admin', 'manager', 'employee'];
        return view('users.edit', compact('user', 'roles'));
    }

    // Update user
    public function update(Request $request, User $user)
    {
        $data = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email,' . $user->id,
            'role' => 'required|in:admin,manager,employee',
        ]);

        $user->update($data);

        return redirect()->route('users.index')->with('success', 'User updated successfully.');
    }

    // Delete user
    public function destroy(User $user)
    {
        if (auth()->id() == $user->id) {
            return redirect()->route('users.index')->with('error', 'You cannot delete yourself.');
        }

        $user->delete();

        return redirect()->route('users.index')->with('success', 'User deleted successfully.');
    }
}
