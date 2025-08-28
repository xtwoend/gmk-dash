<?php

namespace App\Http\Controllers\Api;

use App\Models\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

class AuthController extends Controller
{
    public function login(Request $request)
    {
        // Handle user login logic
        $credentials = $request->only('username', 'password');
        if (! Auth::attempt($credentials)) {
            return response()->json(['error' => 'Unauthorized'], 401);
        }

        $user = Auth::user();
        $user->tokens()->delete();

        // Create a new personal access token
        $token = $user->createToken('Personal Access Token')->plainTextToken;

        return response()->json([
            'token' => $token,
            'user' => [
                'id' => $user->id,
                'username' => $user->username,
                'name' => $user->name,
                'role' => $user->getRoleNames()->first() ?: 'No role assigned',
                'is_superuser' => $user->is_superuser,
                'created_at' => $user->created_at->toIso8601String(),
                'permissions' => $user->getAllPermissions()->pluck('name'),
            ],
            'refreshToken' => $token,
            'expiresIn' => 3600, // Token expiration time in seconds
        ]);
    }

    public function me(Request $request)
    {
        // Return authenticated user data
        $user = $request->user();

        return response()->json([
            'user' => [
                'id' => $user->id,
                'username' => $user->username,
                'name' => $user->name,
                'role' => $user->getRoleNames()->first() ?: 'No role assigned',
                'is_superuser' => $user->is_superuser,
                'created_at' => $user->created_at->toIso8601String(),
                'permissions' => $user->getAllPermissions()->pluck('name'),
            ]
        ]);
    }

    public function verify(Request $request)
    {
        // Handle user verification logic
        $user = $request->user();

        $credentials = $request->only('username', 'password');

        $verificator = User::where('username', $credentials['username'])->first();

        if($verificator === null) {
            return response()->json([
                'message' => 'User not found'
            ], 404);
        }

        if ($verificator && ! password_verify($credentials['password'], $verificator->password)) {
            return response()->json([
                'message' => 'Invalid credentials'
            ], 403);
        }

        return response()->json([
            'id' => $verificator->id,
            'name' => $verificator->name,
            'username' => $verificator->username,
            'is_superuser' => $verificator->is_superuser,
            'role' => $verificator->getRoleNames()->first() ?: 'No role assigned',
            'permissions' => $verificator->getAllPermissions()->pluck('name'),
        ]);
    }

    public function refresh(Request $request)
    {
        // Handle token refresh logic
        $user = $request->user();
        $user->tokens()->delete();

        // Create a new personal access token
        $token = $user->createToken('Personal Access Token')->plainTextToken;

        return response()->json([
            'token' => $token,
            'user' => [
                'id' => $user->id,
                'username' => $user->username,
                'name' => $user->name,
                'role' => $user->getRoleNames()->first() ?: 'No role assigned',
                'is_superuser' => $user->is_superuser,
                'created_at' => $user->created_at->toIso8601String(),
                'permissions' => $user->getAllPermissions()->pluck('name'),
            ],
            'refreshToken' => $token,
            'expiresIn' => 3600, // Token expiration time in seconds
        ]);
    }

    public function logout(Request $request)
    {
        // Handle user logout logic
        $request->user()->tokens()->delete();

        return response()->json(['message' => 'Logout successful']);
    }

    /**
     * Get user by ID.
     */
    public function user($id) {
        $user = User::find($id);

        if (!$user) {
            return response()->json(['message' => 'User not found'], 404);
        }

        return response()->json([
            'id' => $user->id,
            'username' => $user->username,
            'name' => $user->name,
            'role' => $user->getRoleNames()->first() ?: 'No role assigned',
            'is_superuser' => $user->is_superuser,
            'created_at' => $user->created_at->toIso8601String(),
            'permissions' => $user->getAllPermissions()->pluck('name'),
        ]);
    }
}
