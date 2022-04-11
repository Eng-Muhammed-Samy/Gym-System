<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\UserResource;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class CityMangerController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $CityManagers = User::where('role', 'city_manager')->get();
        return response()->json(UserResource::Collection($CityManagers), 200);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        try {
            $validatedRequest = $request->validate([
                'name' => 'required',
                'email' => 'required|email|unique:users',
                'password' => 'required|min:6|confirmed',
                'avatar_image' => 'image|mimes:jpeg,jpg|max:2048',
            ],$messages = [
                'avatar_image.image' => 'this file must be image!',
                'avatar_image.mimes' => 'image must be jpeg or jpg!',
                'avatar_image.max' => 'image maxmum size is 2M!',

            ]);
            if (request()->avatar_image) {
                $filename = time() . '.' . request()->avatar_image->getClientOriginalExtension();
                request()->avatar_image->move(public_path('avatars'), $filename);
            } else
                $filename = 'default.jpg';
            $CityManager = User::create([
                'name' => $validatedRequest['name'],
                'email' => $validatedRequest['email'],
                'password' => Hash::make($validatedRequest['password']),
                'avatar_image' => $filename,
                'role' => "city_manager",
            ]);
        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()], 400);
        }
        return response()->json(new UserResource($CityManager), 201);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $citymanager = User::find($id);
        if (!$citymanager) {
            return response()->json(['error' => 'City Manager not found'], 404);
        }
        return response()->json(new UserResource($citymanager), 200);
    }
    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $citymanager = User::find($id);
        if ($citymanager) {
            try {
                $validatedRequest = $request->validate([
                    'name' => 'required|string',
                    'email' => "required|email|unique:users,email,$id,id",
                    'avatar_image' => 'image|mimes:jpeg,jpg|max:2048',
                ],$messages=[
                    'avatar_image.image' => 'this file must be image!',
                    'avatar_image.mimes' => 'image must be jpeg or jpg!',
                    'avatar_image.max' => 'image maxmum size is 2M!',
                ]);
                $citymanager->name = $validatedRequest['name'];
                $citymanager->email = $validatedRequest['email'];
                if (request()->avatar_image) {
                    $filename = time() . '.' . request()->avatar_image->getClientOriginalExtension();
                    request()->avatar_image->move(public_path('avatars'), $filename);
                }
                $citymanager->save();
            } catch (\Exception $e) {
                return response()->json(['error' => $e->getMessage()], 400);
            }
            return response()->json(new UserResource($citymanager), 200);
        }
        return response()->json(['error' => 'City Manager not found'], 404);
    }
    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $citymanager = User::find($id);
        // return $citymanager;
        if ($citymanager) {
            try {
                $citymanager->delete();
                return response()->json(['message' => 'City Manager deleted successfully'], 200);
            } catch (\Exception $e) {
                return response()->json(['error' => $e->getMessage()], 400);
            }
        }
        return response()->json(['error' => 'City Manager not found'], 404);
    }
}
