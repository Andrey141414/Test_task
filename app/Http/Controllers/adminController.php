<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\bookModel;
use App\Models\bookAndGenreModel;
use App\Models\genreModel;
use App\Models\User;
use Illuminate\Support\Facades\Validator;
class adminController extends Controller
{
    //

   public function all_genres()
   {
    return response()->json(genreModel::pluck('title')->all());
   }
   
   public function all_users_with_book_count()
   {

    $users = User::all();
    $response = array();

    foreach($users as $user)
    {
        array_push($response,([
            'name_user'=>$user->name,
            'count_book'=>bookModel::where('id_user',$user->id)->count(),
        ]));
    }
    return $response;
   }

   public function  all_book_with_user_and_genres()
   {

    $response = array();
    foreach(bookModel::all() as $book)
    {
        $id_genres = bookAndGenreModel::where('id_book',$book->id)->pluck('id_genre');
        $genres = genreModel::find($id_genres)->pluck('title');
        array_push($response,([
            'name_user'=>User::where('id',$book->id_user)->first()->name,
            'title_book'=>$book->title,
            'genres'=>$genres,
        ]));
    }
    return $response;
    }
    
}
