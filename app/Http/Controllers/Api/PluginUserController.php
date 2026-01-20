<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\PluginUser;

class PluginUserController extends Controller
{
    // Get all users
    public function index()
    {
        return response()->json(PluginUser::all());
    }

    // Create new user
    public function store(Request $request)
    {
        $request->validate([
            'email' => 'required|email|unique:plugin_user,email',
            'plan'  => 'nullable|string',
            'domain'=> 'nullable|string',
            'status'=> 'in:active,inactive',
        ]);

        $user = PluginUser::create($request->all());

        return response()->json([
            'message' => 'Plugin User created successfully',
            'data' => $user
        ], 201);
    }

    // Get single user
    public function show($id)
    {
        $user = PluginUser::find($id);

        if (!$user) {
            return response()->json(['message' => 'User not found'], 404);
        }

        return response()->json($user);
    }

    // Update user
    public function update(Request $request, $id)
    {
        $user = PluginUser::find($id);

        if (!$user) {
            return response()->json(['message' => 'User not found'], 404);
        }

        $user->update($request->all());

        return response()->json([
            'message' => 'User updated successfully',
            'data' => $user
        ]);
    }

    // Delete user
    public function destroy($id)
    {
        $user = PluginUser::find($id);

        if (!$user) {
            return response()->json(['message' => 'User not found'], 404);
        }

        $user->delete();

        return response()->json(['message' => 'User deleted successfully']);
    }
}
