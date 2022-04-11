<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Gym;
use App\Models\TrainingSession;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        // $authenticate_user = Auth::user();
        if (auth('sanctum')->check()) {
            switch (auth('sanctum')->user()->role) {
                case 'admin':
                    $city_mangers = User::whrere('role', '=', 'city_manager')->get();
                    $gym_managers = User::whrere('role', '=', 'gym_manager')->get();
                    $users = User::whrere('role', '=', 'user')->get();
                    $gyms = Gym::all();
                    $sessions=TrainingSession::all();
                    return response()->json([
                        'city_managers' => $city_mangers,
                        'gym_managers' => $gym_managers,
                        'users' => $users,
                        'gyms' => $gyms,
                        'sessions'=>$sessions
                    ]);
                    break;
                case 'city_manager':
                    $gym_managers = User::whrere('role', '=', 'gym_manager')->get();
                    $users = User::whrere('role', '=', 'user')->get();
                    return response()->json([
                        'gym_managers' => $gym_managers,
                        'users' => $users
                    ]);
                    break;
                case 'gym_manager':
                    $gyms  = Gym::all();
                    $users = User::whrere('role', '=', 'user')->get();
                    return response()->json([
                        'gyms' => $gyms,
                        'users' => $users
                    ]);
                    break;
                case "user":
                    return "Work in progress";
                    break;
                default:
                    return response()->json([
                        'message' => 'You are not authorized to access this page'
                    ]);
            }
        }
        else
        {
            // return Auth::user();
            return response()->json([
                'message' => 'You are not authorized to access this page'
            ]);
        }

    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
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
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
