<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Spatie\Permission\Models\Role;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
    public function index()
    {
        $user = Auth::user();
        
        // Get user permissions and roles for menu authorization
        $userPermissions = $user->getAllPermissions()->pluck('name')->toArray();
        $userRoles = $user->getRoleNames()->toArray();
        
        return view('dashboard.index', compact('user', 'userPermissions', 'userRoles'));
    }
    
    public function profile()
    {
        $roles = Role::all();
        return view('dashboard.profile', compact('roles'));
    }

    public function updateProfile(Request $request)
    {
        $user = Auth::user();

        $request->validate([
            'name' => 'required|string|max:255',
            'username' => 'required|string|max:255|unique:users,username,' . $user->id,
            'password' => 'nullable|string|min:8|confirmed',
        ]);

        $user->name = $request->name;
        $user->username = $request->username;

        if ($request->filled('password')) {
            $user->password = bcrypt($request->password);
        }

        $user->save();

        return redirect()->route('dashboard.profile')->with('success', 'Profile updated successfully.');
    }
}
