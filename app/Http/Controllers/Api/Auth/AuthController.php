<?php

namespace App\Http\Controllers\Api\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class AuthController extends Controller
{
    public function generateNextCode() {
        $lastCode = User::max('user_code');

        if (!$lastCode) {
            return 'AA0001';
        }

        $letters = substr($lastCode, 0, 2); // Get the two-letter part
        $number = (int)substr($lastCode, 2); // Get the numeric part

        $number += 1;

        if ($number > 9999) {
            $number = 1;
            $letters = $this->incrementLetters($letters); // Move to the next letter sequence
        }

        return $letters . str_pad($number, 4, '0', STR_PAD_LEFT);
    }

    private function incrementLetters($letters) {
        $first = ord($letters[0]) - ord('A');
        $second = ord($letters[1]) - ord('A');

        $second += 1;

        if ($second > 25) {
            $second = 0;
            $first += 1;
        }

        if ($first > 25) {
            throw new Exception("No more codes available.");
        }

        return chr($first + ord('A')) . chr($second + ord('A'));
    }



    public function register(Request $request) {
        $validator=Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:6',
            'phone' => 'required|string|max:255|unique:users',
            'image' => 'nullable',
            'role' => 'nullable|in:admin,user,security'
        ]);
        if ($validator->fails()) {
            return response()->json($validator->errors(), 400);
        }
        $user=User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'phone' => $request->phone,
            'image' => $request->image ??'',
            'role' => $request->role ?? 'user',
            'user_code' => $this->generateNextCode()
        ]);
        $token = $user->createToken('auth_token')->plainTextToken;
        return response()->json([
            'message'=>'User created successfully',
            'user' => $user,
            'token' => $token
        ]);

        }
        public function login(Request $request){
            $validator=Validator::make($request->all(), [
                'email' => 'required|string|email|max:255',
                'password' => 'required|string|min:6',
            ]);
            if ($validator->fails()) {
                return response()->json($validator->errors(), 400);
            }
            $user = User::where('email', $request->email)->first();
            if (!$user || !Hash::check($request->password, $user->password)) {
                return response()->json(['message' => 'Invalid credentials'], 401);
            }
            if (is_null($user->user_code)) {
                $user->user_code = $this->generateNextCode();
                $user->save();
            }

            $token = $user->createToken('auth_token')->plainTextToken;
            return response()->json([
                'message' => 'Login successful',
                'user' => $user,
                'token' => $token
            ]);
        }
    }

