<?php

namespace App\Http\Controllers\Api\SuperAdmin;

use App\Http\Controllers\Controller;
use App\Models\Building;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\Traits\CodeGenerator;

class BuildingController extends Controller
{
    use CodeGenerator;
    protected $updatebuilding=['name','zone_id','country_id','city_id'];


    public function addbuilding(Request $request){
        $validator=Validator::make($request->all(), [
            'name'=>'required|string|unique:buildings',
            'country_id'=>'required|exists:countries,id',
            'city_id'=>'required|exists:cities,id',
            'zone_id'=>'required|exists:zones,id',
        ]);
        if ($validator->fails()) {
            return response()->json(['error' => $validator->errors()], 401);
        }
        $building=Building::create([
            'name'=>$request->name,
            'country_id'=>$request->country_id,
            'city_id'=>$request->city_id,
            'zone_id'=>$request->zone_id,
            'code'=>$this->generateNextCode()
        ]);
        return response()->json(['building'=>$building]);
    }

    public function getBuilding(){
        $building=Building::all();
        return response()->json(['building'=>$building]);
    }

    public function updatebuilding(Request $request,$id){
        $building=Building::find($id);
        $building->update($request->only($this->updatebuilding));
        return response()->json(['message'=>'building updated successfully']);
    }

    public function deletebuilding($id){
        $building=Building::find($id);
        $building->delete();
        return response()->json(['message'=>'building deleted successfully']);
    }
}
