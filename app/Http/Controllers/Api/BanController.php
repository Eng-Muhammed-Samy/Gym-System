<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Ban;
use Illuminate\Http\Request;

class BanController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return Ban::all();
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
                'user_id'=>'required|integer|exists:users,id',
                'reason' => 'required|string',
            ],$messages = [
                'user_id.required' => 'User is required!',
                'user_id.exists' => 'User does not exist!',
            ]);
            $Ban=Ban::create([
                'user_id'=>$validatedRequest['user_id'],
                'reason' => $validatedRequest['reason']
            ]);
        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()], 400);
        }
        return response()->json($Ban, 200);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $Ban = Ban::find($id);
        if (!$Ban) {
            return response()->json(['error' => 'This ban not found'], 404);
        }
        return response()->json($Ban, 200);
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
        try {
            $validatedRequest = $request->validate([
                'reason' => 'required|string',
            ]);
            $Ban = Ban::find($id);
            if (!$Ban) {
                return response()->json(['error' => 'This ban not found'], 404);
            }
            $Ban->reason = $validatedRequest['reason'];
            $Ban->save();
        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()], 400);
        }
        return response()->json($Ban, 200);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $Ban=Ban::find($id);
        if($Ban)
            try{
                $Ban->destroy();
                return response()->json("Successfully deleted", 204);
            }
            catch(\Exception $e){
                return response()->json(['error' => $e->getMessage()], 400);
            }
        else
            return response()->json(['error' => 'Gym Manager not found'], 404);
    }
}