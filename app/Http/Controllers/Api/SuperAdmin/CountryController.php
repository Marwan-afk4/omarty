<?php

namespace App\Http\Controllers\Api\Superadmin;

use App\Http\Controllers\Controller;
use App\Models\Country;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class CountryController extends Controller
{
    protected $countryUpdate=['name','country_flag'];

    public function getCountry(){
        $country=Country::all();
        return response()->json(['country'=>$country]);
    }

    public function addcountry(Request $request){
    $validator=Validator::make($request->all(), [
        'name' => 'required|string|unique:countries',
        'country_flag' => 'nullable',
    ]);
    if ($validator->fails()) {
        return response()->json(['error' => $validator->errors()], 401);
    }
    $country=Country::create([
        'name'=>$request->name,
        'country_flag'=>$request->country_flag
    ]);
    return response()->json(['country'=>$country]);
    }

    public function updatecountry(Request $request, $id){
        $country=Country::find($id);
        $country->update($request->only($this->countryUpdate));
        return response()->json(['message'=>'Country updated successfully']);
    }

    public function deletecountry($id){
        $country=Country::find($id);
        $country->delete();
        return response()->json(['message'=>'Country deleted successfully']);
    }
}
