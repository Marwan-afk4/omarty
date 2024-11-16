<?php

namespace App\Http\Controllers\Api\SuperAdmin;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use App\Traits\CodeGeneratorforUsers;

class AdminController extends Controller
{
    protected $updateadmin=['name','email','phone','password','image','city_id','building_id','zone_id'];

    use CodeGeneratorforUsers;

    public function getadmin(){
        $admin=User::where('role','admin')
        ->with(['building:id,name,code'])
        ->get();
        return response()->json(['admin'=>$admin]);
    }

    public function addadmin(Request $request){
        $validator = Validator::make($request->all(), [
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
        $admin=User::create([
            'name'=>$request->name,
            'email'=>$request->email,
            'password'=>Hash::make($request->password),
            'phone'=>$request->phone,
            'image'=>$request->image?? null,
            'role'=>'admin',
            'building_id'=>$request->building_id ,
            'city_id'=>$request->city_id,
            'zone_id'=>$request->zone_id,
            'user_code'=>$this->generateNextCode()
        ]);
        return response()->json([
            'message'=>'admin added successfully',
            'admin'=>$admin
        ]);
    }

    public function updateadmin(Request $request,$id){
        $admin=User::find($id);
        $admin->update($request->only($this->updateadmin));
        return response()->json(['message'=>'admin updated successfully']);
    }

    public function deleteadmin($id){
        $admin=User::find($id);
        $admin->delete();
        return response()->json(['message'=>'admin deleted successfully']);
    }
}
