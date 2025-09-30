<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;
use Illuminate\Validation\Rules\Password;

class UserController extends Controller
{

    // Index Page
    public function index()
    {
        $users = User::latest()->paginate(10);
        return view('users.index', compact('users'));
    }

    // Add User Form
    public function create()
    {
        return view('users.create');
    }

    // Store New User
    public function store(Request $request)
    {
        $validated = $request->validate([
            'full_name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => ['required', 'confirmed', Password::min(8)],
            'country_code' => 'required|string',
            'phone' => 'required|string|max:20',
            'profile_picture' => 'required|image|mimes:jpg,jpeg,png|max:2048',
        ]);

        $validated['phone'] = $validated['country_code'] . $validated['phone'];
        
        unset($validated['country_code']);

        $validated['profile_picture'] = $request->file('profile_picture')->store('profile_pictures', 'public');

        $validated['password'] = Hash::make($validated['password']);

        User::create($validated);

        return redirect()->route('users.index')->with('success', 'User registered successfully!');
    }

    // View User Details
    public function show(User $user)
    {
        return view('users.show', compact('user'));
    }

    // Edit User Form
    public function edit(User $user)
    {
        return view('users.edit', compact('user'));
    }

    // Update User Details
    public function update(Request $request, User $user)
    {
        $validated = $request->validate([
            'full_name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email,' . $user->id,
            'password' => 'nullable|min:8|confirmed',
            'country_code' => 'required|string',
            'phone_number' => 'required|string|max:20',
            'profile_picture' => 'nullable|image|mimes:jpeg,jpg,png|max:2048'
        ]);

        $validated['phone'] = $validated['country_code'] . $validated['phone_number'];
        
        unset($validated['country_code'], $validated['phone_number']);

        if ($request->hasFile('profile_picture')) {
            // Delete old profile picture if exists
            if ($user->profile_picture && Storage::disk('public')->exists($user->profile_picture)) {
                Storage::disk('public')->delete($user->profile_picture);
            }
            $validated['profile_picture'] = $request->file('profile_picture')->store('profile_pictures', 'public');
        }

        if ($request->filled('password')) {
            $validated['password'] = Hash::make($validated['password']);
        } else {
            unset($validated['password']);
        }

        $user->update($validated);

        return redirect()->route('users.show', $user)->with('success', 'User updated successfully!');
    }


    // Delete User
    public function destroy(User $user)
    {
        // Delete profile picture if exists
        if ($user->profile_picture) {
            Storage::disk('public')->delete($user->profile_picture);
        }

        $user->delete();

        return redirect()->route('users.index')->with('success', 'User deleted successfully!');
    }
}
