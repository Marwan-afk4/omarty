<?php

namespace App\Http\Controllers\Api\SuperAdmin;

use App\Http\Controllers\Controller;
use App\Models\Plan;
use GuzzleHttp\Promise\Create;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class PlanController extends Controller
{
    protected $updateplan=['name','content','description','subscription_type','price','price_discount','duration'];
    public function getplans(){
        $plans =Plan::all();
        return response()->json(['plans'=>$plans]);
    }

    public function addplan(Request $request){
        $validator= Validator::make($request->all(),[
            'name'=>'required|string|unique:plans',
            'content'=>'required|string',
            'description'=>'nullable|string',
            'subscription_type'=>'required|string|in:free,monthly,yearly',
            'price'=>'required|numeric',
            'price_discount'=>'nullable|numeric',
            'duration'=>'required|string',
        ]);
        if($validator->fails()){
            return response()->json(['error'=>$validator->errors()],401);
        }

        $plan = Plan::create([
            'name'=>$request->name,
            'content'=>$request->content,
            'description'=>$request->description,
            'subscription_type'=>$request->subscription_type,
            'price'=>$request->price,
            'price_discount'=>$request->price_discount,
            'duration'=>$request->duration
        ]);
        return response()->json([
            'message'=>'plan added successfully',
            'plan'=>$plan,
        ]);
    }

    public function updateplan(Request $request,$id){
        $validator = Validator::make($request->all(), [
            'name' => 'nullable|string|unique:plans,name,' . $id,
            'content' => 'nullable|string',
            'description' => 'nullable|string',
            'subscription_type' => 'nullable|string|in:free,monthly,yearly',
            'price' => 'nullable|numeric',
            'price_discount' => 'nullable|numeric',
            'duration' => 'nullable|numeric',
        ]);

        if ($validator->fails()) {
            return response()->json(['error' => $validator->errors()], 401);
        }
        $plan=Plan::find($id);
        $plan->name=$request->name ?? $plan->name;
        $plan->content=$request->content ?? $plan->content;
        $plan->description=$request->description ?? $plan->description;
        $plan->subscription_type=$request->subscription_type ?? $plan->subscription_type;
        $plan->price=$request->price ?? $plan->price;
        $plan->price_discount=$request->price_discount ?? $plan->price_discount;
        $plan->duration=$request->duration ?? $plan->duration;
        $plan->save();
        return response()->json([
            'message' => 'plan updated successfully',
            'plan' => $plan,
        ]);

    }

    public function deleteplan($id){
        $plan=Plan::find($id);
        $plan->delete();
        return response()->json(['message'=>'plan deleted successfully']);
    }
}
