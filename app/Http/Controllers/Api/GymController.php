<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\Gym\StoreGymRequest;
use App\Http\Requests\Gym\UpdateGymRequest;
use App\Http\Resources\Gym\GymResource;
use App\Models\City;
use Illuminate\Http\Request;
use App\Models\Gym;
use App\Models\GymManager;
use Illuminate\Support\Facades\Validator;

class GymController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return GymResource::collection(Gym::all());
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $request = new StoreGymRequest($request->all());
        // logger($request);
        $validatedRequest = Validator::make(
            $request->all(),
            $request->rules(),
            $request->messages()
        );
        if ($validatedRequest->fails()) {
            return response()->json(['status' => 'error', 'errors' => $validatedRequest->errors()]);
        }
        try {
            $gym = Gym::create([
                'name' => $request->name,
                'city_id' => $request->city_id,
                'created_by' => auth('sanctum')->user()
            ]);
            foreach ($request->gym_managers as $manager) {
                $gym_manager = GymManager::find($manager);
                $gym_manager->gym_id = $gym->id;
                $gym_manager->save();
            }
        } catch (\Exception $e) {
            return response()->json(['status' => 'error', 'errors' => $e->getMessage()]);
        }
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
            return response()->json(['status' => "error", 'error' => 'Gym not found']);
        }
        return response()->json(new GymResource($gym), 200);
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
        $request = new UpdateGymRequest($request->all());
        $validatedRequest = validator::make(
            $request->all(),
            $request->rules(),
            $request->messages()
        );
        if ($validatedRequest->fails()) {
            return response()->json(['status' => 'error', 'errors' => $validatedRequest->errors()]);
        }
        $gym = Gym::find($id);
        if ($gym) {
            $gym->name = $request->name;
            $gym->city_id = $request->city_id;
            $gym->save();
            return response()->json($gym, 200);
        }
        return response()->json(['status' => 'error', 'error' => 'Gym not found']);
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
        if ($gym) {
            $sessions =$gym->training_sessions();
            foreach($sessions as $session) {
                if($session->isActive ) {
                    return response()->json(['status' => 'error', 'error' => 'Cannot delete gym, there are active sessions']);
                }
            }
            $gym->delete();
            return response()->json(null, 204);
        }
        
        return response()->json(['status' => 'error', 'error' => 'Gym not found']);
    }

    public function removeManager(Request $request)
    {
        $validatedRequest = validator::make(
            $request->all(),
            [
                'gym_id' => 'required',
                'gym_manager_id' => 'required|exists:gym_managers,id,gym_id,' . $request->gym_id
            ],
            [
                'gym_id.required' => "Can't find this gym",
                'gym_manager_id.required' => "Can't reach this gym manager",
                'gym_manager_id.exists' => 'Gym manager not valid'
            ]
        );
        if ($validatedRequest->fails()) {
            return response()->json(['status' => 'error', 'errors' => $validatedRequest->errors()]);
        }
        $gym_manager = GymManager::find($request->gym_manager_id);
        $gym_manager->gym_id = null;
        $gym_manager->save();
        return response()->json(null, 204);
    }

    public function addManager(Request $request)
    {
        logger($request);
        $validatedRequest = validator::make(
            $request->all(),
            [
                'gym_id' => 'required',
                'gym_manager_id' => 'required|exists:gym_managers,id,gym_id,NULL'
            ],
            [
                'gym_id.required' => "Can't find this gym",
                'gym_manager_id.required' => "Can't reach this gym manager",
                'gym_manager_id.exists' => 'Gym manager not valid'
            ]
        );
        if ($validatedRequest->fails()) {
            return response()->json(['status' => 'error', 'errors' => $validatedRequest->errors()]);
        }
        $gym_manager = GymManager::find($request->gym_manager_id);
        $gym_manager->gym_id = $request->gym_id;
        $gym_manager->save();
        return response()->json(null, 204);
    }
}
