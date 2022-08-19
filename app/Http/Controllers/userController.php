<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\bookModel;
use Illuminate\Support\Facades\Validator;
class userController extends Controller
{
    public function userInfo(User $user)
    {
        
        return response()->json([
            'id'=> $user->id,
            'email'=> $user->email ,
            'name' => $user->name,
            ]);
    }


    public function get_user(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'id_user' => 'required|exists:App\Models\User,id',
        ]);
        if ($validator->fails()) {
            return response()->json([
                'message' => 'Validation error'
            ], 400);
        }

        $user = (new User())->where('id',$request->input('id_user'))->first();
        return response()->json([
            'user' => $user
        ], 200);
       
    }

    public function create_user(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|between:2,100',
            'email' => 'required|email|unique:users|max:50',
            'password' => 'required|string|min:6',
            'is_admin' => 'required',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'message' => 'Validation error'
            ], 400);
        }
        $user = User::create(array_merge(
                $validator->validated(),
                ['password' => bcrypt($request->password)],

    ));

    $user->save();
    return response()->json([
        'message' => 'Successfully created',
        'user' => $user
    ], 200);
         
    }




    public function update_user(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'id_user'=>'required|exists:App\Models\User,id',
            'name' => 'required|between:2,100',
            'email' => 'required|email|max:50',
            //'password' => 'required|string|min:6',
            'is_admin' => 'required|boolean',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'message' => 'Validation error'
            ], 400);
        }       
        $user = User::where('id',$request->input('id_user'))->first();
        
        $user->name = $request->input('name');
        $user->email = $request->input('email');
        //$user->password = bcrypt($request->input('password'));
        $user->is_admin = $request->input('is_admin');

        $user->save();


    return response()->json([
        'message' => 'Successfully updated',
        'user' => $user
    ], 200);

    }

    public function delete_user(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'id_user' => 'required|exists:App\Models\User,id',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'message' => 'Validation error'
            ], 400);
        }

        $user = User::where('id',$request->input('id_user'))->first()->delete();
        return response()->json([
            'message' => 'user was deleted'
        ], 200);
    }

    public function user_info_with_books(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'id_user'=>'required|exists:App\Models\User,id',]);
        
            if ($validator->fails()) {
            return response()->json([
                'message' => 'Validation error'
            ], 400);
        }

        $user = User::where('id',$request->input('id_user'))->first();
        
        $books = bookModel::where('id_user',$user->id)->pluck('title');
        
        

        return response()->json([
            'name'=>$user->name,
            'email'=>$user->email,
            'books'=>$books,
        ]);
    }
    
}
