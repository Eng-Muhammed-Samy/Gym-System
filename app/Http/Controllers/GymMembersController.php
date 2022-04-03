<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Log;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\Models\Gym_Member;
use App\Models\User;
use Illuminate\Support\Facades\File;
use App\Http\Requests\Gym_Members\StoreGym_MembersRequest;
use App\Http\Requests\Gym_Members\UpdateGym_MembersRequest;
use App\Http\Resources\Gym_Members\GymMemberResource;
use Illuminate\Validation\Rules\Password;
use Illuminate\Support\Facades\Storage;
use Illuminate\Filesystem\FilesystemAdapter;

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
            $imageFileName = time() . $request->avatar_image->getClientOriginalname();
            $res = $request->file("avatar_image")->storeAs("", $imageFileName, "google");
            Storage::disk("google")->setVisibility($res, "public");
            $url = Storage::disk("google")->url($imageFileName);
            $image_id_on_drive = substr($url, 31, 33);
            $user = User::create(["name" => $request->name, "email" => $request->email, "password" => $request->password, "avatar_image" => $image_id_on_drive, "role" => "Gym_Member"]);
            Gym_Member::create(["user_id" => $user->id, "gender" => $request->gender, "date_of_birth" => $request->date_of_birth]);
            return response()->json(['status' => 'success', "data" => GymMemberResource::Collection(Gym_Member::all())]);
        } catch (\Exception $ex) {
        }
    }


    public function update($id, Request $request)
    {


        try {
            $validator = Validator::make($request->all(), UpdateGym_MembersRequest::getRules($request->id, gettype($request->avatar_image)), UpdateGym_MembersRequest::getMessages());
            if ($validator->fails()) {

                return response()->json(['status' => 'error', 'errors' => $validator->errors()]);
            }
            if (gettype($request->avatar_image) != "string") {

                $imageFileName = time() . $request->avatar_image->getClientOriginalname();
                $res = $request->file("avatar_image")->storeAs("", $imageFileName, "google");
                Storage::disk("google")->setVisibility($res, "public");
                $url = Storage::disk("google")->url($imageFileName);
                $image_id_on_drive = substr($url, 31, 33);
            } else {
                $image_id_on_drive = $request->avatar_image;
            }
            $user = User::find($id);
            $user = $user->update(["name" => $request->name, "email" => $request->email, "password" => $request->password, "avatar_image" => $image_id_on_drive, "role" => "Gym_Member"]);
            $gym_member =  Gym_Member::where('user_id', $id);
            $gym_member = $gym_member->update(["gender" => $request->gender, "date_of_birth" => $request->date_of_birth]);
            return response()->json(['status' => 'success', "data" => GymMemberResource::Collection(Gym_Member::all())]);
        } catch (\Exception $ex) {
        }
    }

    public function destroy($id)
    {
        try {
            $gym_member = Gym_Member::find($id);
            $image_id_on_drive = $gym_member->user->avatar_image;
            Storage::disk('google')->delete($image_id_on_drive);
            $gym_member->delete();
            return response()->json(['message' => "deleted"]);
        } catch (\Exception $ex) {
        }
    }
}
