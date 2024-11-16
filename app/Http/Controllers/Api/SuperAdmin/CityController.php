<?php

namespace App\Http\Controllers\Api\Superadmin;

use App\Http\Controllers\Controller;
use App\Models\City;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class CityController extends Controller
{
    protected $updatecity=['name','country_id'];
    public function getcity(){
        $city = City::all();
        return response()->json(['cities'=>$city]);
    }

    public function addCity(Request $request){
        $validator = Validator::make($request->all(), [
            'name'=>'required|string|unique:cities',
            'country_id'=>'required|exists:countries,id'
        ]);

        if($validator->fails()){
            return response()->json(['errors'=>$validator->errors()]);
        }

        $city = City::create([
            'name'=>$request->name,
            'country_id'=>$request->country_id
        ]);
        return response()->json(['message'=>'city added successfully']);
    }

    public function updateCity(Request $request,$id){
        $city=City::find($id);
        $city->update($request->only($this->updatecity));
        return response()->json(['message'=>'city updated successfully']);
    }

    public function deletecity($id){
        $city=City::find($id);
        $city->delete();
        return response()->json(['message'=>'city deleted successfully']);
    }

}
