<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Attendance;

class AttendanceController extends Controller
{
    public function index()
    {
        return Attendance::all();
    }

    public function store(Request $request)
    {
        try{
        $validatedRequest=$request->validate([
            'user_id' => 'required',
            'training_session_id' => 'required',
            'attendance_time' => 'required',
            'attendance_date' => 'required',
        ]);
        $attendance = Attendance::create([
            'user_id' => $validatedRequest['user_id'],
            'training_session_id' => $validatedRequest['training_session_id'],
            'attendance_time' => $validatedRequest['attendance_time'],
            'attendance_date' => $validatedRequest['attendance_date'],
        ]);
        }catch(\Exception $e){
            return response()->json(['error'=>$e->getMessage()],400);
        }
        return response()->json($attendance, 201);
    }

    public function show($attendance_id)
    {
        $attendance = Attendance::find($attendance_id);
        if (!$attendance) {
            return response()->json(['error' => 'Attendance not found'], 404);
        }
        return response()->json($attendance, 200);
    }

    public function update(Request $request, $attendance_id)
    {
        return response()->json(['error' => 'Not implemented'], 501);
        try{
        $validatedRequest=$request->validate([
            'user_id' => 'required',
            'training_session_id' => 'required',
            'attendance_time' => 'required',
            'attendance_date' => 'required',
        ]);
        $attendance = Attendance::find($attendance_id);
        if(!$attendance){
            return response()->json(['error'=>'Attendance not found'],404);
        }
        $attendance->user_id = $validatedRequest['user_id'];
        $attendance->training_session_id = $validatedRequest['training_session_id'];
        $attendance->attendance_time = $validatedRequest['attendance_time'];
        $attendance->attendance_date = $validatedRequest['attendance_date'];
        $attendance->save();
        }catch(\Exception $e){
            return response()->json(['error'=>$e->getMessage()],400);
        }
        return response()->json($attendance, 200);
    }

    public function destroy($attendance_id)
    {
        $attendance = Attendance::find($attendance_id);
        if(!$attendance){
            return response()->json(['error'=>'Attendance not found'],404);
        }
        try{
        $attendance->delete();
        }catch(\Exception $e){
            return response()->json(['error'=>$e->getMessage()],400);
        }
        return response()->json("Sucessfully deleted", 204);
    }
}
