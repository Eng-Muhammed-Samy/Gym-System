<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Coach;

class CoachController extends Controller
{
    public function index()
    {
        return Coach::all();
    }

    public function store(Request $request)
    {
        try{
        $validatedRequest=$request->validate([
            'name' => 'required',
            'session_id' => 'required',
        ]);
        $coach = Coach::create([
            'name' => $validatedRequest['name'],
            'session_id' => $validatedRequest['session_id']
        ]);
        }catch(\Exception $e){
            return response()->json(['error'=>$e->getMessage()],400);
        }
        return response()->json($coach, 201);
    }

    public function show($coach_id)
    {
        $coach = Coach::find($coach_id);
        if (!$coach) {
            return response()->json(['error' => 'Coach not found'], 404);
        }
        return response()->json($coach, 200);
    }

    public function update(Request $request, $coach_id)
    {
        try{
        $validatedRequest=$request->validate([
            'name' => 'required',
            'session_id' => 'required',
        ]);
        $coach = Coach::find($coach_id);
        if(!$coach){
            return response()->json(['error'=>'Coach not found'],404);
        }
        $coach->name = $validatedRequest['name'];
        $coach->session_id = $validatedRequest['session_id'];
        $coach->save();
        }catch(\Exception $e){
            return response()->json(['error'=>$e->getMessage()],400);
        }
        return response()->json($coach, 200);
    }

    public function destroy($coach_id)
    {
        $coach = Coach::find($coach_id);
        if (!$coach) {
            return response()->json(['error' => 'Coach not found'], 404);
        }
        $coach->delete();
        return response()->json(null, 204);
    }
}
