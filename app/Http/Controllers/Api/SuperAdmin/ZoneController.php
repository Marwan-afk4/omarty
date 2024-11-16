<?php

namespace App\Http\Controllers\Api\SuperAdmin;

use App\Http\Controllers\Controller;
use App\Models\Zone;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class ZoneController extends Controller
{
    protected $updatezone=['name','country_id','city_id'];
    public function getZone(){
        $zone=Zone::all();
        return response()->json(['zone'=>$zone]);
    }

    public function addzonde(Request $request){
        $validator = Validator::make($request->all(), [
            'name'=>'required|string|unique:zones',
            'country_id'=>'required|exists:countries,id',
            'city_id'=>'required|exists:cities,id'
        ]);

        if($validator->fails()){
            return response()->json(['errors'=>$validator->errors()]);
        }

        $zone = Zone::create([
            'name'=>$request->name,
            'country_id'=>$request->country_id,
            'city_id'=>$request->city_id
        ]);
        return response()->json(['message'=>'zone added successfully']);
    }

    public function updatezonde(Request $request,$id){
        $zone=Zone::find($id);
        $zone->update($request->only($this->updatezone));
        return response()->json(['message'=>'zone updated successfully']);
    }

    public function deletezonde($id){
        $zone=Zone::find($id);
        $zone->delete();
        return response()->json(['message'=>'zone deleted successfully']);
    }
}
