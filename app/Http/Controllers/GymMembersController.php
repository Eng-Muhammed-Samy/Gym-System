<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\Models\Gym_Member;
use App\Models\User;
use App\Http\Requests\Gym_Members\StoreGym_MembersRequest;
use App\Http\Requests\Gym_Members\UpdateGym_MembersRequest;
use App\Http\Resources\Gym_Members\GymMemberResource;
use Illuminate\Support\Facades\Hash;

class GymMembersController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $allGym_Members = Gym_Member::all();
        return GymMemberResource::Collection($allGym_Members);
    }

    public function store(Request $request)
    {
        try {
            $validator = Validator::make($request->all(), StoreGym_MembersRequest::getRules(), StoreGym_MembersRequest::getMessages());
            if ($validator->fails()) {
                return response()->json(['status' => 'error', 'errors' => $validator->errors()]);
            }
            if ($request->file("avatar_image")) {
                $filename = time() . '.' . $request->file("avatar_image")->getClientOriginalExtension();
                $request->file("avatar_image")->move(public_path('avatars'), $filename);
            } else
                $filename = 'default.jpg';
            $user = User::create(["name" => $request->name, "email" => $request->email, "password" => Hash::make($request->password), "avatar_image" => $filename, "role" => "user"]);
            $Gym_Member=Gym_Member::create(["user_id" => $user->id, "gender" => $request->gender, "date_of_birth" => $request->date_of_birth]);
            return response()->json(['status' => 'success', "data" => new GymMemberResource($Gym_Member)]);
        } catch (\Exception $ex) {
            return response()->json([
                'status' => 'error',
                'errors' => $ex->getMessage()
            ]);
        }
    }


    public function update($id, Request $request)
    {
        try {
            $validator = Validator::make($request->all(), UpdateGym_MembersRequest::getRules($request->id, gettype($request->avatar_image)), UpdateGym_MembersRequest::getMessages());
            if ($validator->fails()) {

                return response()->json(['status' => 'error', 'errors' => $validator->errors()]);
            }
            $user = User::find($id);
            $user = $user->update(["name" => $request->name, "email" => $request->email,]);
            $gym_member =  Gym_Member::where('user_id', $id)->first();
            $gym_member->gender=$request->gender;
            $gym_member->date_of_birth=$request->date_of_birth;
            $gym_member->save();;
            return response()->json(['status' => 'success', "data" => new GymMemberResource($gym_member)]);
        } catch (\Exception $ex) {
            return response()->json([
                'status' => 'error',
                "error" => $ex->getMessage()
            ]);
        }
    }

    public function destroy($id)
    {
        try {
            $gym_member = Gym_Member::find($id);
            $gym_member->delete();
            return response()->json(['message' => "deleted"]);
        } catch (\Exception $ex) {
            return response()->json([
                'status' => 'error',
                "error" => $ex->getMessage()
            ]);
        }
    }
}
