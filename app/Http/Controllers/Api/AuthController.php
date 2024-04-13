<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\Models\User;
use App\Rules\ValidFaculty;
use App\Rules\ValidDepartment;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;

class AuthController extends Controller
{
    //
    public function createUser(Request $request)
    {
        try {
            $validateUser = Validator::make($request->all(), [
                "first_name" => "required",
                "last_name" => "required",
                "email" => "required|email|unique:users,email",
                "phone_number" => "required|unique:users,phone_number",
                "account_type" => "required|in:0,1", // Ensure account_type is provided and valid
                "password" => ["required", "min:6", "max:255", "regex:/^(?=.*[a-zA-Z])(?=.*\d)(?=.*[@$!%*?&])[A-Za-z\d@$!%*?&]+$/"], // Requires password to be at least 6 characters and include at least one letter, one number, and one symbol
            ], [
                "password.regex" => "The password must be at least 6 characters long and contain at least one letter, one number, and one symbol."
            ]);


            if($validateUser->fails()){
                return response()->json([
                    'status' => false,
                    'message' => $validateUser->errors()->first()
                ], 401);
            }

            // Create user based on account_type
            $userData = [
                'first_name' => $request->first_name,
                'last_name' => $request->last_name,
                'other_name' => $request->other_name,
                'email' => $request->email,
                'phone_number' => $request->phone_number,
                'account_type' => $request->account_type,
                'password' => Hash::make($request->password)
            ];

            if ($request->account_type == 1) {
                // Additional validation and data for student
                $validateStudent = Validator::make($request->all(), [
                    "university_id" => "required|exists:universities,id",
                    "faculty_id" => ["required", new ValidFaculty($request->input('university_id'))],
                    "department_id" => ["required", new ValidDepartment($request->input('faculty_id'))],
                    "school_level_id" => "required|exists:school_levels,id",
                    "level_semester_id" => "required|exists:level_semesters,id",
                ]);

                if ($validateStudent->fails()) {
                    return response()->json([
                        'status' => false,
                        'message' => $validateStudent->errors()->first()
                    ], 401);
                }

                // Assign student-related data
                $userData['university_id'] = $request->university_id;
                $userData['faculty_id'] = $request->faculty_id;
                $userData['department_id'] = $request->department_id;
                $userData['school_level_id'] = $request->school_level_id;
                $userData['level_semester_id'] = $request->level_semester_id;
            }

            $user = User::create($userData);

            if ($request->account_type == 1) {

                return response()->json([
                    'status' => true,
                    'message' => "Student Created Successfully",
                    'token' => $user->createToken('API TOKEN')->plainTextToken
                ], 200);

            }

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
                'token' => $user->createToken('API TOKEN')->plainTextToken
                // 'token' => $user->createToken('API TOKEN')->plainTextToken
            ], 200);

        } catch (\Throwable $th) {
            return response()->json([
                'status' => false,
                'message' => $th->getMessage()
            ], 500);
        }

    }

    public function me(Request $request)
    {
        try {
            //code...
            $token = $request->bearerToken();

            return $token;

        } catch (\Throwable $th) {
            return response()->json([
                'status' => false,
                'message' => $th->getMessage()
            ], 500);
        }
    }
}
