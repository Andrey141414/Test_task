<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Validator;
class authControler extends Controller
{
    public function register(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|between:2,100',
            'email' => 'required|email|unique:users|max:50',
            'password' => 'required|string|min:6',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'message' => 'Validation error'
            ], 400);
        }



/////////////////////////////////////////////////////////////
         
        $user = User::create(array_merge(
                $validator->validated(),
                ['password' => bcrypt($request->password)],

    ));
    


    $user->save();


    return response()->json([
        'message' => 'Successfully registered',
        'user' => $user
    ], 200);
    }

    public function login(Request $request)
    {

        $validator = Validator::make($request->all(), [
            'email' => 'required|email',
            'password' => 'required|string|min:6',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'message' => 'Validation error'
            ], 400);
        }

        if (!auth('web')->attempt($validator->validated())) {
            return response()->json([
                'message' => 'Unauthorized'
            ], 401);
        }

        $token = $request->user()->createToken('token');
 
        return ['token' => $token->plainTextToken];
    }

    public function user_data(Request $request)
    {
    
        return response()->json($request->user());

    }

    public function logout(Request $request)
    {
        $request->user()->tokens()->delete();
        return response()->json([
            'message' => 'Successfully logout'], 200);
    }
}
