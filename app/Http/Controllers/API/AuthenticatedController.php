<?php

namespace App\Http\Controllers\API;

use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

class AuthenticatedController extends Controller
{
    /**
     * Login api
     *
     * @return \Illuminate\Http\Response
     */
    public function login(Request $request): JsonResponse
    {
        if (Auth::attempt(['email' => $request->email, 'password' => $request->password])) {
            $user = Auth::user();
            $data['token'] =  $user->createToken('API')->plainTextToken;
            $data['name'] =  $user->name;

            return response()->json([
                'success' => true,
                'code' => '200',
                'message' => 'User login successfully.',
                'data' => $data
            ]);
        } else {
            return response()->json([
                'success' => false,
                'code' => '401',
                'message' => 'Unauthorised'
            ], 401);
        }
    }
}
