<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\Models\genreModel;
class genreController extends Controller
{
    public function get_genre(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'id_genre' => 'required|exists:App\Models\genreModel,id',
        ]);
        if ($validator->fails()) {
            return response()->json([
                'message' => 'Validation error'
            ], 400);
        }
        $genre = genreModel::where('id',$request->input('id_genre'))->first();
        return response()->json($genre);
    }

    public function create_genre(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'title' => 'required',
        ]);


        if ($validator->fails()) {
            return response()->json([
                'message' => 'Validation error'
            ], 400);
        }

        $genre = new genreModel();
        $genre->title = $request->input('title');
        
        $genre->save();
        return response()->json($genre);
         
    }

    public function update_genre(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'id_genre' => 'required|exists:App\Models\genreModel,id',
            'title' => 'required',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'message' => 'Validation error'
            ], 400);
        }
        

        $genre = genreModel::where('id',$request->input('id_genre'))->first();
        $genre->title = $request->input('title');
        $genre->save();
        return response()->json($genre);

    }

    public function delete_genre(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'id_genre' => 'required|exists:App\Models\genreModel,id',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'message' => 'Validation error'
            ], 400);
        }

        $genre = genreModel::where('id',$request->input('id_genre'))->first()->delete();
        return response()->json([
            'message' => 'genre was deleted'
        ], 200);
    }
}
