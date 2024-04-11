<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;

class UserController extends Controller
{
    //
    public function createUser(Request $request)
    {
        try {
            $validateUser = Validator::make($request->all(),
            [
                "first_name" => "required",
                "last_name" => "required",
                "email" => "required|email|unique:users,email",
                "phone_number" => "required|unique:users,phone_number",
                "account_type" => "required",
                "password" => ["required", "min:6", "max:255", "regex:/^(?=.*[a-zA-Z])(?=.*\d)(?=.*[@$!%*?&])[A-Za-z\d@$!%*?&]+$/"], // Requires password to be at least 6 characters and include at least one letter, one number, and one symbol

            ],[
                "password.regex" => "The password must be at least 6 characters long and contain at least one letter, one number, and one symbol."
            ]);

            if($validateUser->fails()){
                return response()->json([
                    'status' => false,
                    'message' => $validateUser->errors()->first()
                ], 401);
            }

            $user = User::create([
                'first_name' => $request->first_name,
                'last_name' => $request->last_name,
                'other_name' => $request->other_name,
                'email' => $request->email,
                'phone_number' => $request->phone_number,
                'account_type' => $request->account_type,
                'password' => Hash::make($request->password)
            ]);

            return response()->json([
                'status' => true,
                'message' => "User Created Successfully",
                'token' => $user->createToken('API TOKEN')->plainTextToken
            ], 200);

        } catch (\Throwable $th) {
            return response()->json([
                'status' => false,
                'message' => $th->getMessage()
            ], 500);
        }

    }

    public function loginUser(Request $request)
    {

        try {
            $validateUser = Validator::make($request->all(),
            [
                "username" => "required",
                "password" => ["required", "min:6", "max:255", "regex:/^(?=.*[a-zA-Z])(?=.*\d)(?=.*[@$!%*?&])[A-Za-z\d@$!%*?&]+$/"], // Requires password to be at least 6 characters and include at least one letter, one number, and one symbol

            ],[
                "password.regex" => "The password must be at least 6 characters long and contain at least one letter, one number, and one symbol."
            ]);


            if($validateUser->fails()){
                return response()->json([
                    'status' => false,
                    'message' => $validateUser->errors()->first()
                ], 401);
            }

            // if(!Auth::attempt(['email' => $request->email, 'password' => $request->password])()){
            if (!Auth::attempt(['email' => $request->username, 'password' => $request->password]) && !Auth::attempt(['phone_number' => $request->username, 'password' => $request->password])) {
                return response()->json([
                    'status' => false,
                    'message' => 'Sorry, we couldn\'t find an account with the provided credentials. Please double-check and try again.'
                ], 401);

            }

            $user = User::where('email', $request->username)->orWhere('phone_number', $request->username)->first();

            return response()->json([
                'status' => true,
                'message' => "User Logged in Successfully",
                'token' => $user->createToken('API TOKEN')->plainTextToken,
                'data' => $user
                // 'token' => $user->createToken('API TOKEN')->plainTextToken
            ], 200);

        } catch (\Throwable $th) {
            return response()->json([
                'status' => false,
                'message' => $th->getMessage()
            ], 500);
        }

    }
}
