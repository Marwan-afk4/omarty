<?php

namespace App\Http\Controllers\Api\SuperAdmin;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use App\Traits\CodeGeneratorforUsers;

class SecurityController extends Controller
{
    use CodeGeneratorforUsers;

    protected $updatesecurity=['name','email','password','phone','image','city_id','building_id','zone_id'];

    public function getsecurity(){
        $security=User::where('role','security')->get();
        return response()->json(['security'=>$security]);
    }

    public function addsecurity(Request $request){
        $validator=Validator::make($request->all(), [
            'name'=>'required|string|max:255',
            'email'=>'required|string|email|max:255|unique:users',
            'password'=>'required|string|min:6',
            'phone'=>'required|string|max:255|unique:users',
            'image'=>'nullable',
            'city_id'=>'required|exists:cities,id',
            'building_id'=>'required|exists:buildings,id',
            'zone_id'=>'required|exists:zones,id',
        ]);
        if ($validator->fails()) {
            return response()->json(['error' => $validator->errors()], 401);
        }
        $security=User::create([
            'name'=>$request->name,
            'email'=>$request->email,
            'password'=>Hash::make($request->password),
            'phone'=>$request->phone,
            'image'=>$request->image?? null,
            'role'=>'security',
            'building_id'=>$request->building_id ,
            'city_id'=>$request->city_id,
            'zone_id'=>$request->zone_id,
            'user_code'=>$this->generateNextCode()
        ]);
        return response()->json([
            'message'=>'security added successfully',
            'security'=>$security
        ]);
    }

    public function updatesecurity(Request $request,$id){
        $security=User::find($id);
        $security->update($request->only($this->updatesecurity));
        return response()->json(['message'=>'security updated successfully']);
    }

    public function deletesecurity($id){
        $security=User::find($id);
        $security->delete();
        return response()->json(['message'=>'security deleted successfully']);
    }
}
