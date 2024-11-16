<?php

namespace App\Http\Controllers\Api\SuperAdmin;

use App\Http\Controllers\Controller;
use App\Models\Request as ModelsRequest;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class RequestController extends Controller
{
    public function getRequests(){
        $requests=ModelsRequest::with([
            'user:id,name,role',
            'country:id,name',
            'city:id,name,country_id'
        ])->get();
        return response()->json(['Requests'=>$requests]);
    }

    public function addrequest(Request $request){
        $validator = Validator::make($request->all(),[
            'user_id'=>'required|exists:users,id',
            'country_id'=>'required|exists:countries,id',
            'city_id'=>'required|exists:cities,id',
            'zone'=>'required|max:255',
            'building_name'=>'required|max:255',
            'attachment_image'=>'nullable'
        ]);
        if($validator->fails()){
            return response()->json(['erros'=>$validator->errors()],401);
        }

        $request = ModelsRequest::create([
            'user_id'=>$request->user_id,
            'country_id'=>$request->country_id,
            'city_id'=>$request->city_id,
            'zone'=>$request->zone,
            'building_name'=>$request->building_name,
            'attachment_image'=>$request->attachment_image ?? '',
            'status'=>'pending'
        ]);
        return response()->json(['message'=>'request added successfully','request'=>$request]);
    }

    public function statusapproved($id){
        $approved = ModelsRequest::findOrFail($id);
        $approved->status = 'approved';
        $approved->save();
        $user=User::find($approved->user_id);
        if($user){
            $user->role='admin';
            $user->save();
        }
        return response()->json(['message'=>'request approved successfully']);
    }


    public function statusrejected($id){
        $rejected = ModelsRequest::findOrFail($id);
        $rejected->status = 'rejected';
        $rejected->save();
        return response()->json(['message'=>'request rejected successfully']);
    }

    public function deleterequest($id){
        $requests=ModelsRequest::findOrFail($id);
        $requests->delete();
        return response()->json(['message'=>'request deleted successfully']);
    }

    public function showimage($id){
        $imagerequest=ModelsRequest::findOrFail($id);
        $show_image=$imagerequest->attachment_image;
        $image=[
            'image'=>$show_image
        ];
        return response()->json(['images'=>$image]);
    }
}
