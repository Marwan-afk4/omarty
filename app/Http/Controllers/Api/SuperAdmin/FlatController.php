<?php

namespace App\Http\Controllers\Api\SuperAdmin;

use App\Http\Controllers\Controller;
use App\Models\Flat;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\Traits\CodeGenerator;

class FlatController extends Controller
{
    use CodeGenerator;
    protected $updateflat=['flat_number','building_id','zone_id','city_id'];


    public function addFlat(Request $request){
        $validator=Validator::make($request->all(),[
            'flat_number'=>'required|numeric',
            'building_id'=>'required|exists:buildings,id',
            'zone_id'=>'required|exists:zones,id',
            'city_id'=>'required|exists:cities,id'
        ]);
        if ($validator->fails()){
            return response()->json(['error' => $validator->errors()], 401);
        }
        $flat=Flat::create([
            'flat_number'=>$request->flat_number,
            'building_id'=>$request->building_id,
            'zone_id'=>$request->zone_id,
            'city_id'=>$request->city_id,
            'code'=>$this->generateNextCode()
        ]);
        return response()->json(['message'=>'flat added successfully','flat'=>$flat]);
    }

    public function getflat(){
        $flat=Flat::all();
        return response()->json(['flats'=>$flat]);
    }

    public function updateflat(Request $request,$id){
        $flat=Flat::find($id);
        $flat->update($request->only($this->updateflat));
        return response()->json(['message'=>'flat updated successfully']);
    }

    public function deleteflat($id){
        $flat=Flat::find($id);
        $flat->delete();
        return response()->json(['message'=>'flat deleted successfully']);
    }
}
