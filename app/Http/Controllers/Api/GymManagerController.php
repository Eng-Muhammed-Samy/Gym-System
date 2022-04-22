<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\UserResource;
use App\Models\GymManager;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class GymManagerController extends Controller
{
    function index()
    {
        $GymManagers = GymManager::all();
        return response()->json($GymManagers, 200);
    }
    public function withoutGyms()
    {
        $GymManagers = GymManager::where('gym_id', null)->get();
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
            return response()->json(['error' => $e->getMessage()]);
        }
        return response()->json(new UserResource($GymManager), 201);
    }

    function show($gym_manager_id)
    {
        $GymManager = User::find($gym_manager_id);
        if (!$GymManager) {
            return response()->json(['error' => 'Gym Manager not found']);
        }
        return response()->json(new UserResource($GymManager));
    }

    function update(Request $request, $gym_manager_id)
    {
        try {
            $validatedRequest = $request->validate([
                'name' => 'required',
                'email' => 'required|email|unique:users,email,$id,id',
                // 'avatar_image' => 'image|mimes:jpeg,jpg|max:2048',
            ]);
            // if (request()->avatar_image) {
            //     $filename = time() . '.' . request()->avatar_image->getClientOriginalExtension();
            //     request()->avatar_image->move(public_path('avatars'), $filename);
            // }
            $GymManager = User::find($gym_manager_id);
            if (!$GymManager) {
                return response()->json(['error' => 'Gym Manager not found']);
            }
            $GymManager->name = $validatedRequest['name'];
            $GymManager->email = $validatedRequest['email'];
            $GymManager->save();
        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()]);
        }
        return response()->json(new UserResource($GymManager));
    }

    function destroy($gym_manager_id)
    {
        $GymManager = GymManager::find($gym_manager_id);
        if ($GymManager) {
            try {
                if ($GymManager->gym_id)
                return response()->json(['status' => 'error', 'error' => 'Gym Manager is assigned to a gym']);
                $GymManager->user->delete();
                $GymManager->delete();
                return response()->json(['status' => "success", 'message' => 'Gym Manager deleted successfully']);
            } catch (\Exception $e) {
                return response()->json(['status' => "error", 'error' => $e->getMessage()]);
            }
        }
        return response()->json(['status' => 'error', 'error' => 'Gym Manager not found']);
    }
}
