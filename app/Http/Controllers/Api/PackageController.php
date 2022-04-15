<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Package;

class PackageController extends Controller
{
    public function index()
    {
        return Package::all();
    }

    public function store(Request $request)
    {
        try{
        $validatedRequest=$request->validate([
            'name' => 'required|unique:packages',
            'price' => 'required|numeric',
            'gym_id' => 'required|exists:gyms,id',
            'session_count' => 'required|numeric',
            'discount' => 'nullable|numeric|min:0|max:100',
        ]);
        $package = Package::create([
            'name' => $validatedRequest['name'],
            'price' => $validatedRequest['price'],
            'gym_id' => $validatedRequest['gym_id'],
            'session_count' => $validatedRequest['session_count'],
            'discount' => $validatedRequest['discount'],
        ]);
        }catch(\Exception $e){
            return response()->json(['error'=>$e->getMessage()],400);
        }
        return response()->json($package, 201);
    }

    public function show($package_id)
    {
        $package = Package::find($package_id);
        if (!$package) {
            return response()->json(['error' => 'Package not found'], 404);
        }
        return response()->json($package, 200);
    }

    public function update(Request $request, $package_id)
    {
        try{
        $validatedRequest=$request->validate([
            'name' => 'required|unique:packages,name',
            'price' => 'required|numeric',
            'gym_id' => 'required|exists:gyms,id',
            'session_count' => 'required|numeric',
            'discount' => 'nullable|numeric|min:0|max:100',
        ]);
        $package = Package::find($package_id);
        if(!$package){
            return response()->json(['error'=>'Package not found'],404);
        }
        $package->name = $validatedRequest['name'];
        $package->price = $validatedRequest['price'];
        $package->gym_idgym_id = $validatedRequest['gym_id'];
        $package->session_count = $validatedRequest['session_count'];
        $package->discount = $validatedRequest['discount'];
        $package->save();
        }catch(\Exception $e){
            return response()->json(['error'=>$e->getMessage()],400);
        }
        return response()->json($package, 200);
    }

    public function destroy($package_id)
    {
        $package = Package::find($package_id);
        if(!$package){
            return response()->json(['error'=>'Package not found'],404);
        }
        $package->delete();
        return response()->json(null, 204);
    }
}
