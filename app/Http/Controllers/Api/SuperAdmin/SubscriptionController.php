<?php

namespace App\Http\Controllers\Api\SuperAdmin;

use App\Http\Controllers\Controller;
use App\Models\Plan;
use App\Models\Subscription;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class SubscriptionController extends Controller
{

    public function getsubscriptions(){
        $subscriptions=Subscription::with([
        'user:id,name,phone',
        'plan:id,name',
        'country:id,name',
        'city:id,name,country_id',
        'zone:id,name,country_id,city_id',
        'building:id,name,country_id,city_id,zone_id,code'])->get();
        return response()->json(['subscriptions'=>$subscriptions]);
    }

    public function addsubscription(Request $request){
        $validator=Validator::make($request->all(),[
            'user_id'=>'required|exists:users,id',
            'plan_id'=>'required|exists:plans,id',
            'start_date'=>'required|date',
            'end_date'=>'required|date'
        ]);
        if ($validator->fails()){
            return response()->json(['error'=>$validator->errors()],401);
        }
        $plan=Plan::find($request->plan_id);

        $subscription=Subscription::create([
            'user_id'=>$request->user_id,
            'plan_id'=>$request->plan_id,
            'sub_price'=>$plan->price_discount,
            'start_date'=>$request->start_date,
            'end_date'=>$request->end_date
        ]);
        return response()->json(['message'=>'subscription added successfully','subscription'=>$subscription]);
    }

}
