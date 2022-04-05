<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Attendance;
use App\Models\TrainingSession;
use Illuminate\Http\Request;
use App\Models\User;

class SessionController extends Controller
{
    public function index()
    {
        return TrainingSession::all();
    }

    public function store(Request $request)
    {
        $sessionOverlaps = TrainingSession::where('gym_id','=',$request->gym_id)->where('session_date','=',$request->session_date)
        ->where('start_time', '<=', $request->start_time)->where('end_time', '>=', $request->end_time)
        ->get();

        if (count($sessionOverlaps) > 0) {
            return response()->json(['error' => 'Session overlaps with another session'], 400);
        }
        try{
        $validatedRequest=$request->validate([
            'name' => 'required|unique:training_sessions',
            'start_time' => 'required',
            'end_time' => 'required',
            'session_date' => 'required',
            'gym_id' => 'required',
        ]);
        $session = TrainingSession::create([
            'name' => $validatedRequest['name'],
            'start_time' => $validatedRequest['start_time'],
            'end_time' => $validatedRequest['end_time'],
            'session_date' => $validatedRequest['session_date'],
            'gym_id' => $validatedRequest['gym_id'],
        ]);
        }catch(\Exception $e){
            return response()->json(['error'=>$e->getMessage()],400);
        }
        return response()->json($session, 201);
    }

    public function show($session_id)
    {
        $session = TrainingSession::find($session_id);
        if (!$session) {
            return response()->json(['error' => 'Session not found'], 404);
        }
        return response()->json($session, 200);
    }

    public function update(Request $request,$session_id)
    {
        try{
        $validatedRequest=$request->validate([
            'start_time' => 'required',
            'end_time' => 'required',
            'session_date' => 'required',
        ]);
        $session = TrainingSession::find($session_id);
        if(!$session){
            return response()->json(['error'=>'Session not found'],404);
        }
        $userAttending = Attendance::where('training_session_id','=',$session_id)->get();
        if($userAttending->count()>0){
            return response()->json(['error'=>'Session is currently in use'],400);
        }
        $session->start_time = $validatedRequest['start_time'];
        $session->end_time = $validatedRequest['end_time'];
        $session->session_date = $validatedRequest['session_date'];
        $session->save();
        }catch(\Exception $e){
            return response()->json(['error'=>$e->getMessage()],400);
        }
        return response()->json($session, 201);
    }

    public function destroy($session_id)
    {
        $session = TrainingSession::find($session_id);
        if(!$session){
            return response()->json(['error'=>'Session not found'],404);
        }
        $userAttending = Attendance::where('training_session_id','=',$session_id)->get();
        if($userAttending->count()>0){
            return response()->json(['error'=>'Session is currently in use'],400);
        }
        try{
            $session->delete();
        }catch(\Exception $e){
            return response()->json(['error'=>$e->getMessage()],400);
        }
        return response()->json("Sucessfully deleted", 204);
    }
}
