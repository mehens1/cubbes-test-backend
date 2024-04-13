<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Resources\UserResource;
use Illuminate\Support\Facades\Auth;

class UserController extends Controller
{
    public function show(Request $request)
    {
        try {
            //code...
            $token = $request->bearerToken();

            $user = auth()->user();
            if($user){
                return new UserResource($user);
            }

            return response()->json([
                'status' => false,
                'message' => "User Not Authenticated!"
            ], 401);

        } catch (\Throwable $th) {
            return response()->json([
                'status' => false,
                'message' => $th->getMessage()
            ], 500);
        }
    }
}
