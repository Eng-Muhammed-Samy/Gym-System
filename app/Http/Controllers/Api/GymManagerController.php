<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class GymManagerController extends Controller
{
    function index()
    {
        $GymManagers = User::where('role', 'gym_manager')->get();
        return response()->json($GymManagers, 200);
    }

    function store(Request $request)
    {
        try {
            $validatedRequest = $request->validate([
                'name' => 'required',
                'email' => 'required|email|unique:users',
                'password' => 'required|min:8',
                'avatar_image' => 'required|image|mimes:jpeg,jpg|max:2048',
            ]);
            if (request()->avatar_image) {
                $filename = time() . '.' . request()->avatar_image->getClientOriginalExtension();
                request()->avatar_image->move(public_path('avatars'), $filename);
            } else
                $filename = 'default.jpg';

            $GymManager = User::create([
                'name' => $validatedRequest['name'],
                'email' => $validatedRequest['email'],
                'password' => Hash::make($validatedRequest['password']),
                'avatar_image' => $filename,
                'role' => "gym_manager",
            ]);
        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()], 400);
        }
        return response()->json($GymManager, 201);
    }

    function show($gym_manager_id)
    {
        $GymManager = User::find($gym_manager_id);
        if (!$GymManager) {
            return response()->json(['error' => 'Gym Manager not found'], 404);
        }
        return response()->json($GymManager, 200);
    }

    function update(Request $request, $gym_manager_id)
    {
        try {
            $validatedRequest = $request->validate([
                'name' => 'required',
                'email' => 'required|email',
                'avatar_image' => 'image|mimes:jpeg,jpg|max:2048',
            ]);
            if (request()->avatar_image) {
                $filename = time() . '.' . request()->avatar_image->getClientOriginalExtension();
                request()->avatar_image->move(public_path('avatars'), $filename);
            }
            $GymManager = User::find($gym_manager_id);
            if (!$GymManager) {
                return response()->json(['error' => 'Gym Manager not found'], 404);
            }
            $GymManager->name = $validatedRequest['name'];
            $GymManager->email = $validatedRequest['email'];
            $GymManager->save();
        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()], 400);
        }
        return response()->json($GymManager, 200);
    }

    function destroy($gym_manager_id)
    {
        $GymManager = User::find($gym_manager_id);
        if (!$GymManager) {
            return response()->json(['error' => 'Gym Manager not found'], 404);
        }
        try{
        $GymManager->delete();
        }catch(\Exception $e){
            return response()->json(['error' => $e->getMessage()], 400);
        }
        return response()->json("Successfully deleted", 204);
    }
}
