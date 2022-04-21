<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\CityManager\StoreCityManagerRequest;
use App\Http\Requests\CityManager\UpdateCityManagerRequest;
use App\Http\Resources\CityManagerResource\CityManagerResource;
use App\Http\Resources\UserResource;
use App\Models\City;
use App\Models\CityManager;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class CityMangerController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $CityManagers = CityManager::all();
        return response()->json(CityManagerResource::Collection($CityManagers), 200);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreCityManagerRequest $request)
    {
        logger($request->city_id);
        try {
            $validatedRequest = Validator::make(
                $request->all(),
                $request->rules(),
                $request->messages()
            );
            if($validatedRequest->fails()){
                logger("fails()");
                return response()->json(['status' => 'error', 'errors' => $validatedRequest->errors()]);
            }
            if ($request->file("avatar_image")) {
                $filename = time() . '.' . $request->file("avatar_image")->getClientOriginalExtension();
                $request->file("avatar_image")->move(public_path('avatars'), $filename);
            } else
                $filename = 'default.jpg';

            $User = User::create([
                'name' => $request['name'],
                'email' => $request['email'],
                'password' => Hash::make($request['password']),
                'avatar_image' => $filename,
                'role' => "city_manager",
            ]);
            $CityManager=CityManager::create([
                'user_id' => $User->id,
                // 'city_id' => $request['city_id'],
            ]);
            City::find($request['city_id'])->update(['city_manager_id' => $CityManager->id]);
        } catch (\Exception $e) {
            logger("e");
            return response()->json(['status' => 'error', 'errors' => $e,'error' => $validatedRequest->errors()]);

        }
        return response()->json(new CityManagerResource($CityManager), 201);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $citymanager = User::find($id)->getRole;
        if (!$citymanager) {
            return response()->jsonx(['error' => 'City Manager not found']);
        }
        return response()->json(new CityManagerResource($citymanager), 200);
    }
    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateCityManagerRequest $request, $id)
    {
        $citymanager = User::where('id',$id)->where('role', 'city_manager')->first();
        if ($citymanager) {
            try {
                $validatedRequest = validator::make(
                    $request->rules(),
                    $request->messages()
            );
                $citymanager->name = $validatedRequest['name'];
                $citymanager->email = $validatedRequest['email'];
                // if (request()->avatar_image) {
                //     $filename =  time() . '.' . request()->avatar_image->getClientOriginalExtension();
                //     request()->avatar_image->move(public_path('avatars'), $filename);
                // }
                $citymanager->save();
            } catch (\Exception $e) {
                return response()->json([
                    'status'=>'error',
                    'error' => $validatedRequest->errors(),
                    'message' => $e->getMessage()
            ]);
            }
            return response()->json(new UserResource($citymanager));
        }
        return response()->json(['status'=>"error",'error' => ["city_id"=>'City Manager not found']]);
    }
    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        logger(`user id is $id`);
        $citymanager = CityManager::where('user_id',$id);
        $User =$citymanager->user;
        if ($citymanager && $User) {
            try {
                if($citymanager->city)
                    $citymanager->city->update(['city_manager_id' => null]);
                $citymanager->delete();
                if($User->avatar_image != 'default.jpg')
                    unlink(public_path('avatars/'.$User->avatar_image));
                $User->delete();
                return response()->json(['status'=>'sucsess','message' => 'City Manager deleted successfully']);
            } catch (\Exception $e) {
                return response()->json(['status'=>'error','error' => $e->getMessage()]);
            }
        }
        return response()->json(['status'=>'error','error' => 'City Manager not found']);
    }
}
