<?php

namespace App\Http\Controllers\Api\SuperAdmin;

use App\Http\Controllers\Controller;
use App\Models\Apartment;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\Traits\CodeGenerator;

class AppartmentController extends Controller
{
    use CodeGenerator;

    protected $updateappartment = ['apartment_name','admin_id','flat_id','building_id','zone_id','city_id','country_id'];

    public function getappartments(){
        $apparmtent = Apartment::with([
            'country:id,name',
            'city:id,name,country_id',
            'zone:id,name,country_id,city_id',
            'building:id,name,country_id,city_id,zone_id',
            'flat:id,flat_number,country_id,city_id,zone_id,building_id',
            'admin:id,name'
        ])->get();
        return response()->json(['appartments'=>$apparmtent]);
    }

    public function addAppartment(Request $request){
        $validator = Validator::make($request->all(), [
            'country_id'=>'required|exists:countries,id',
            'city_id'=>'required|exists:cities,id',
            'zone_id'=>'required|exists:zones,id',
            'building_id'=>'required|exists:buildings,id',
            'flat_id'=>'required|exists:flats,id',
            'admin_id'=>'nullable|exists:users,id',
            'apartment_name'=>'required|string',
        ]);
        if($validator->fails()){
            return response()->json(['errors'=>$validator->errors()], 401);
        }

        $appartment = Apartment::create([
            'country_id'=>$request->country_id,
            'city_id'=>$request->city_id,
            'zone_id'=>$request->zone_id,
            'building_id'=>$request->building_id,
            'flat_id'=>$request->flat_id,
            'admin_id'=>$request->admin_id,
            'apartment_name'=>$request->apartment_name,
            'code'=>$this->generateNextCode()
        ]);
        return response()->json(['message'=>'appartment added successfully','appartment'=>$appartment]);
    }

    public function updateAppartment(Request $request,$id){
        $appartment = Apartment::find($id);
        $appartment->update($request->only($this->updateappartment));
        return response()->json(['message'=>'appartment updated successfully']);
    }

    public function deleteAppartment($id){
        $appartment = Apartment::find($id);
        $appartment->delete();
        return response()->json(['message'=>'appartment deleted successfully']);
    }
}
