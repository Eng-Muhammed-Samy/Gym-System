<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Attendance;
use App\Models\CoachSession;
use App\Models\TrainingSession;
use Illuminate\Http\Request;
use App\Models\User;

use function PHPUnit\Framework\isEmpty;

class SessionController extends Controller
{
    public function index()
    {
        return TrainingSession::all();
    }

    public function store(Request $request)
    {
        try{
        $validatedRequest=$request->validate([
            'name' => 'required|unique:training_sessions',
            'start_time' => 'required',
            'end_time' => 'required',
            'session_date' => 'required',
            'gym_id' => 'required',
            'coaches' => 'required|array|min:1',
        ]);
        $session = new TrainingSession([
            'name' => $validatedRequest['name'],
            'start_time' => $validatedRequest['start_time'],
            'end_time' => $validatedRequest['end_time'],
            'session_date' => $validatedRequest['session_date'],
            'gym_id' => $validatedRequest['gym_id'],
        ]);
        if ($session->getOverlabingSessions()->count() > 0) {
            return response()->json(['error' => 'Session overlaps with another session']);
        }
        $session = TrainingSession::create($session->toArray());
        foreach ($validatedRequest['coaches'] as $coach) {
            CoachSession::create([
                'session_id' => $session->id,
                'coach_id' => $coach,
            ]);
        }
        }catch(\Exception $e){
            return response()->json(['error'=>$e->getMessage()]);
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
            'session_date' => 'required|after:today',
        ]);
        $session = TrainingSession::find($session_id);
        if(!$session){
            return response()->json(['error'=>'Session not found']);
        }
        if($session->getOverlabingSessions()->count() > 0){
            return response()->json(['error'=>'Session overlaps with another session']);
        }
        if($session->attendance->count()>0){
            return response()->json(['error'=>'Session is currently in use']);
        }
        $session->start_time = $validatedRequest['start_time'];
        $session->end_time = $validatedRequest['end_time'];
        $session->session_date = $validatedRequest['session_date'];
        $session->save();
        }catch(\Exception $e){
            return response()->json(['error'=>$e->getMessage()]);
        }
        return response()->json($session, 201);
    }

    public function destroy($session_id)
    {
        $session = TrainingSession::find($session_id);
        if(!$session){
            return response()->json(['error'=>'Session not found']);
        }
        if($session->attendance->count()>0){
            return response()->json(['error'=>'Session is currently in use']);
        }
        try{
            $session->delete();
        }catch(\Exception $e){
            return response()->json(['error'=>$e->getMessage()]);
        }
        return response()->json("Sucessfully deleted", 204);
    }
}
