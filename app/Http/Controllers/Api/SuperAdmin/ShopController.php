<?php

namespace App\Http\Controllers\Api\SuperAdmin;

use App\Http\Controllers\Controller;
use App\Models\Shop;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\Traits\CodeGenerator;

class ShopController extends Controller
{
    use CodeGenerator;

    protected $updateshop = ['country_id','city_id','zone_id','building_id','flat_id','admin_id','shop_name'];

    public function getShops(){
        $shop = Shop::with([
            'country:id,name',
            'city:id,name,country_id',
            'zone:id,name,country_id,city_id',
            'building:id,name,country_id,city_id,zone_id',
            'flat:id,flat_number,country_id,city_id,zone_id,building_id',
            'admin:id,name'
        ]);
        return response()->json(['shops'=>$shop]);
    }

    public function addShop(Request $request){
        $validator = Validator::make($request->all(),[
            'country_id'=>'required|exists:countries,id',
            'city_id'=>'required|exists:cities,id',
            'zone_id'=>'required|exists:zones,id',
            'building_id'=>'required|exists:buildings,id',
            'flat_id'=>'required|exists:flats,id',
            'admin_id'=>'nullable|exists:users,id',
            'shop_name'=>'required|string',
        ]);
        if($validator->fails()){
            return response()->json(['errors'=>$validator->errors()],401);
        }

        $shop = Shop::create([
            'country_id'=>$request->country_id,
            'city_id'=>$request->city_id,
            'zone_id'=>$request->zone_id,
            'building_id'=>$request->building_id,
            'flat_id'=>$request->flat_id,
            'admin_id'=>$request->admin_id,
            'shop_name'=>$request->shop_name,
            'code'=>$this->generateNextCode()
        ]);
        return response()->json(['message'=>'shop added successfully','shop'=>$shop]);
    }

    public function updateShop(Request $request,$id){
        $shop = Shop::find($id);
        $shop->update($request->only($this->updateshop));
        return response()->json(['message'=>'shop updated successfully','shop'=>$shop]);
    }

    public function deleteShop($id){
        $shop = Shop::find($id);
        $shop->delete();
        return response()->json(['message'=>'shop deleted successfully']);
    }
}
