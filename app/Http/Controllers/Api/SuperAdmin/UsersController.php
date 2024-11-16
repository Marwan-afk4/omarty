<?php

namespace App\Http\Controllers\Api\SuperAdmin;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use App\Traits\CodeGeneratorforUsers;

class UsersController extends Controller
{
    protected $updateuser=['name','email','password','phone','image','role','building_id','flat_id','city_id','zone_id'];

    use CodeGeneratorforUsers;

    public function getusers(){
        $users=User::with(['building:id,name,code'])->get();
        return response()->json(['users'=>$users]);
    }

    public function adduser(Request $request){
        $validator=Validator::make($request->all(), [
            'name'=>'required|string|max:255',
            'email'=>'required|string|email|max:255|unique:users',
            'password'=>'required|string|min:6',
            'phone'=>'required|string|max:255|unique:users',
            'image'=>'nullable',
            'role'=>'nullable|in:admin,user,security',
            'building_id'=>'nullable|exists:buildings,id',
            'flat_id'=>'nullable|exists:flats,id',
            'city_id'=>'nullable|exists:cities,id',
            'zone_id'=>'nullable|exists:zones,id'
        ]);
        if ($validator->fails()) {
            return response()->json(['error' => $validator->errors()], 401);
        }
        $user=User::create([
            'name'=>$request->name,
            'email'=>$request->email,
            'password'=>Hash::make($request->password),
            'phone'=>$request->phone,
            'image'=>$request->image?? null,
            'role'=>$request->role??'user',
            'building_id'=>$request->building_id ?? null,
            'city_id'=>$request->city_id ?? null,
            'zone_id'=>$request->zone_id ?? null,
            'flat_id'=>$request->flat_id ?? null,
            'user_code'=>$this->generateNextCode()
        ]);
        return response()->json(
            [
                'message'=>'User created successfully',
                'user'=>$user
            ]
        );
    }

    public function updateuser(Request $request,$id){
        $user=User::find($id);
        $user->update($request->only($this->updateuser));
        return response()->json(['message'=>'user updated successfully']);
    }

    public function deleteuser($id){
        $user=User::find($id);
        $user->delete();
        return response()->json(['message'=>'user deleted successfully']);
    }
}
