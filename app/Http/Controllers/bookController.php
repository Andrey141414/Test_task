<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\Models\bookModel;
use App\Models\User;
use App\Models\genreModel;
use App\Models\bookAndGenreModel;
class bookController extends Controller
{
    public function get_book(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'id_book' => 'required|exists:App\Models\bookModel,id',
        ]);
        if ($validator->fails()) {
            return response()->json([
                'message' => 'Validation error'
            ], 400);
        }
        $book = bookModel::where('id',$request->input('id_book'))->first();
        return response()->json($book);
    }

    public function create_book(Request $request)
    {
        $count_genres = genreModel::count();

        $validator = Validator::make($request->all(), [
            'title' => 'required',
            'id_user' => 'required|exists:App\Models\User,id',
            'id_genre' => 'exists:App\Models\genreModel,id|between:1,count_genres',
        ]);
        if ($validator->fails()) {
            return response()->json([
                'message' => 'Validation error'
            ], 400);
        }

       
        $book = new bookModel();
        $book -> title = $request->input('title');
        $book -> id_user = $request->input('id_user');
        
        $book->save();


        $id_genre = $request->input('id_genre'); 
        foreach($id_genre as $id_gen)
        {
            $book_and_genre = new bookAndGenreModel();
            $book_and_genre->id_book = $book->id;
            $book_and_genre->id_genre = $id_gen;
            $book_and_genre->save();
        }

        return response()->json($book);
    }

    public function update_book(Request $request)
    {
        

        $count_genres = genreModel::count();

        $validator = Validator::make($request->all(), [
            'id_book'=>'required|exists:App\Models\genreModel,id',
            'title' => 'required',
            'id_user' => 'required|exists:App\Models\User,id',
            'id_genre' => 'exists:App\Models\genreModel,id|between:1,count_genres',
        ]);
        if ($validator->fails()) {
            return response()->json([
                'message' => 'Validation error'
            ], 400);
        }

       
        $book = (new bookModel())->where('id',$request->input('id_book'))->first();
        $book -> title = $request->input('title');
        $book -> id_user = $request->input('id_user');
        
        $book->save();

//delete_old_genres
        (new bookAndGenreModel())->where('id_book',$book->id)->delete();

        $id_genre = $request->input('id_genre'); 
        foreach($id_genre as $id_gen)
        {
            $book_and_genre = new bookAndGenreModel();
            $book_and_genre->id_book = $book->id;
            $book_and_genre->id_genre = $id_gen;
            $book_and_genre->save();
        }
        return response()->json($book);
    }

    public function delete_book(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'id_book' => 'required|exists:App\Models\bookModel,id',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'message' => 'Validation error'
            ], 400);
        }

        $book = bookModel::where('id',$request->input('id_book'))->first()->delete();
        return response()->json([
            'message' => 'book was deleted'
        ], 200);
    }



    public function all_books_with_user()
    {
        $response = array();
        foreach(bookModel::all() as $book)
        {
            
            array_push($response,([
                'name_user'=>User::where('id',$book->id_user)->first()->name,
                'title_book'=>$book->title,
            ]));
        }
        return $response;
    }



    public function book_info(Request $request)
    {

        $validator = Validator::make($request->all(), [
            'id_book'=>'required|exists:App\Models\bookModel,id',]);
        
            if ($validator->fails()) {
            return response()->json([
                'message' => 'Validation error'
            ], 400);
        }
        $book = bookModel::where('id',$request->input('id_book'))->first();
        
        

        return response()->json([
            'title'=>$book->title,
            'name_user'=>User::where('id',$book->id_user)->first()->name,
        ]);
        
    }
}
