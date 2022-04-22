<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\Stripe\StripeOperationResource;
use Illuminate\Http\Request;
use App\Models\StripeOperation;

class StripeOperationController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return StripeOperation::all();
    }

    public function stripeFormat()
    {
        return StripeOperationResource::collection(StripeOperation::all()) ; 
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        try{
        $validatedRequest=$request->validate([
            'gym_member_id' => 'required',
            'package_id' => 'required',
            'gym_id' => 'required',
            'paid_amount' => 'required',
        ]);
        $stripeOperation = new StripeOperation([
            'gym_member_id' => $validatedRequest['gym_member_id'],
            'package_id' => $validatedRequest['package_id'],
            'gym_id' => $validatedRequest['gym_id'],
            'paid_amount' => $validatedRequest['paid_amount'],
        ]);
        $stripeOperation = StripeOperation::create($stripeOperation->toArray());
        }catch(\Exception $e){
            return response()->json(['error'=>$e->getMessage()]);
        }
        return response()->json($stripeOperation, 201);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $stripeOperation = StripeOperation::find($id);
        if (!$stripeOperation) {
            return response()->json(['error' => 'Transaction not found']);
        }
        return response()->json($stripeOperation);
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
        try{
        $validatedRequest=$request->validate([
            'gym_member_id' => 'required',
            'package_id' => 'required',
            'gym_id' => 'required',
            'paid_amount' => 'required',
        ]);
        $stripeOperation = StripeOperation::find($id);
        if(!$stripeOperation){
            return response()->json(['error'=>'Transaction not found']);
        }
        $stripeOperation->gym_member_id = $validatedRequest['gym_member_id'];
        $stripeOperation->package_id = $validatedRequest['package_id'];
        $stripeOperation->gym_id = $validatedRequest['gym_id'];
        $stripeOperation->paid_amount = $validatedRequest['paid_amount'];
        $stripeOperation->save();
        }catch(\Exception $e){
            return response()->json(['error'=>$e->getMessage()]);
        }
        return response()->json($stripeOperation, 200);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $stripeOperation = StripeOperation::find($id);
        if(!$stripeOperation){
            return response()->json(['error'=>'Transaction not found']);
        }
        $stripeOperation->delete();
        return response()->json('Transaction deleted successfully', 200);
    }

}
