<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\City;
use Illuminate\Http\Request;

class CityController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return City::all();
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
            $request->validate([
                'name' => 'required|unique:cities',
            ]);
            $City = City::create([
                'name' => $request->name,
            ]);
        } catch (\Exception $e) {
            return response()->json(["error" => $e->getMessage()]);
        }
        return response()->json($City, 201);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $City = City::find($id);
        if ($City)
            return $City;
        else
            return response()->json(["error" => "Can't found this city"]);
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
        $City = City::find($id);
        if ($City) {
            // return $request;
            try {
                $request->validate([
                    'name' => 'required|unique:cities,name,' . $City->id,
                ]);
                $City->name=$request->name;
                $City->save();
                return response()->json($City, 200);
            } catch (\Exception $e) {
                return response()->json(["error" => $e->getMessage()]);
            }
        } else
            return response()->json(["error" => "can't found this city"]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $City = City::find($id);
        if ($City) {
            $City->delete();
            return response('Deleted Successfully', 204);
        }else{
            return response()->json(["error" => "can't found this city"]);
        }
    }
}
