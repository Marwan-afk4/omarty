<?php

namespace App\Http\Controllers\Api\SuperAdmin;

use App\Http\Controllers\Controller;
use App\Models\Office;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\Traits\CodeGenerator;

class OfficeController extends Controller
{
    use CodeGenerator;
    protected $updateOffice = ['country_id','city_id','zone_id','building_id','flat_id','admin_id','office_name'];

    public function getoffices(){
        $offices = Office::with([
            'country:id,name',
            'city:id,name,country_id',
            'zone:id,name,country_id,city_id',
            'building:id,name,country_id,city_id,zone_id',
            'flat:id,flat_number,country_id,city_id,zone_id,building_id',
            'admin:id,name'
        ])->get();
        return response()->json(['offices'=>$offices]);
    }

    public function addoffice(Request $request){
        $validator = Validator::make($request->all(),[
            'country_id'=>'required|exists:countries,id',
            'city_id'=>'required|exists:cities,id',
            'zone_id'=>'required|exists:zones,id',
            'building_id'=>'required|exists:buildings,id',
            'flat_id'=>'required|exists:flats,id',
            'admin_id'=>'nullable|exists:users,id',
            'office_name'=>'required|string',
        ]);
        if($validator->fails()){
            return response()->json(['errors'=>$validator->errors()],401);
        }

        $office = Office::create([
            'country_id'=>$request->country_id,
            'city_id'=>$request->city_id,
            'zone_id'=>$request->zone_id,
            'building_id'=>$request->building_id,
            'flat_id'=>$request->flat_id,
            'admin_id'=>$request->admin_id,
            'office_name'=>$request->office_name,
            'code'=>$this->generateNextCode()
        ]);
        return response()->json(['message'=>'office added successfully','office'=>$office]);
    }

    public function updateOffice(Request $request,$id){
        $office = Office::find($id);
        $office->update($request->only($this->updateOffice));
        return response()->json(['message'=>'office updated successfully','office'=>$office]);
    }

    public function deleteShop($id){
        $shop = Office::find($id);
        $shop->delete();
        return response()->json(['message'=>'office deleted successfully']);
    }
}
