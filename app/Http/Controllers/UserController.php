<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Client;
use App\Models\Vendor;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    public function index()
    {
        $users = User::with(['client', 'vendor'])->get();
        return view('users.index', compact('users'));
    }

    public function create()
    {
        $clients = Client::all();
        $vendors = Vendor::all();
        return view('users.create', compact('clients', 'vendors'));
    }

    public function store(Request $request)
    {
        $rules = [
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users',
            'password' => 'required|min:6|confirmed',
            'role' => 'required|in:admin,manager,staff,client,vendor',
            'phone' => 'nullable|string|max:20',
        ];

        // Add validation for client_id and vendor_id based on role
        if ($request->role === 'client') {
            $rules['client_id'] = 'required|exists:clients,id';
        } elseif ($request->role === 'vendor') {
            $rules['vendor_id'] = 'required|exists:vendors,id';
        }

        $validated = $request->validate($rules);

        $userData = [
            'name' => $validated['name'],
            'email' => $validated['email'],
            'password' => Hash::make($validated['password']),
            'role' => $validated['role'],
            'phone' => $validated['phone'] ?? null,
        ];

        // Add client_id or vendor_id if applicable
        if ($request->role === 'client') {
            $userData['client_id'] = $validated['client_id'];
        } elseif ($request->role === 'vendor') {
            $userData['vendor_id'] = $validated['vendor_id'];
        }

        User::create($userData);

        return redirect()->route('users.index')->with('success', 'User created successfully');
    }

    public function show(User $user)
    {
        return view('users.show', compact('user'));
    }

    public function edit(User $user)
    {
        $clients = Client::all();
        $vendors = Vendor::all();
        return view('users.edit', compact('user', 'clients', 'vendors'));
    }

    public function update(Request $request, User $user)
    {
        $rules = [
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email,' . $user->id,
            'role' => 'required|in:admin,manager,staff,client,vendor',
            'phone' => 'nullable|string|max:20',
        ];

        if ($request->role === 'client') {
            $rules['client_id'] = 'required|exists:clients,id';
        } elseif ($request->role === 'vendor') {
            $rules['vendor_id'] = 'required|exists:vendors,id';
        }

        $validated = $request->validate($rules);

        $userData = [
            'name' => $validated['name'],
            'email' => $validated['email'],
            'role' => $validated['role'],
            'phone' => $validated['phone'] ?? null,
        ];

        // Handle client_id/vendor_id
        if ($request->role === 'client') {
            $userData['client_id'] = $validated['client_id'];
            $userData['vendor_id'] = null;
        } elseif ($request->role === 'vendor') {
            $userData['vendor_id'] = $validated['vendor_id'];
            $userData['client_id'] = null;
        } else {
            $userData['client_id'] = null;
            $userData['vendor_id'] = null;
        }

        // Only update password if provided
        if ($request->filled('password')) {
            $request->validate(['password' => 'min:6|confirmed']);
            $userData['password'] = Hash::make($request->password);
        }

        $user->update($userData);

        return redirect()->route('users.index')->with('success', 'User updated successfully');
    }

    public function destroy(User $user)
    {
        // Prevent deleting yourself
        if ($user->id === auth()->id()) {
            return redirect()->route('users.index')->with('error', 'Cannot delete your own account');
        }

        $user->delete();
        return redirect()->route('users.index')->with('success', 'User deleted successfully');
    }
}