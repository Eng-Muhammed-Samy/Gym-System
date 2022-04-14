<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Gym;

class GymController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return Gym::all();
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $validatedRequest=$request->validate([
            'name' => 'required|unique:gyms',
            'city_id' => 'required',
            'city_manager_id' => 'required',
        ]);
        $gym = new Gym([
            'name' => $validatedRequest['name'],
            'city_id' => $validatedRequest['city_id'],
            'city_manager_id' => $validatedRequest['city_manager_id'],
        ]);
        $gym->save();
        return response()->json($gym, 201);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $gym = Gym::find($id);
        if (!$gym) {
            return response()->json(['error' => 'Gym not found']);
        }
        return response()->json($gym, 200);
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
        $validatedRequest=$request->validate([
            'name' => 'required',
            'city_id' => 'required',
            'city_manager_id' => 'required',
        ]);
        $gym = Gym::find($id);
        if (!$gym) {
            return response()->json(['error' => 'Gym not found']);
        }
        $gym->name = $validatedRequest['name'];
        $gym->city_id = $validatedRequest['city_id'];
        $gym->city_manager_id = $validatedRequest['city_manager_id'];
        $gym->save();
        return response()->json($gym, 200);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $gym = Gym::find($id);
        if (!$gym) {
            return response()->json(['error' => 'Gym not found']);
        }
        $gym->delete();
        return response()->json(null, 204);
    }
}
