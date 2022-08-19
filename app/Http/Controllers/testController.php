<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\bookModel;

class testController extends Controller
{
    //
    public function testBd()
    {

        $books = new bookModel();
        return response()->json($books::all());
        //return 200;
    }
}
