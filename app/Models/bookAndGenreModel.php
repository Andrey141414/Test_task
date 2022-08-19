<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class bookAndGenreModel extends Model
{
    use HasFactory;
    public $timestamps = false;
    protected $table = "book_and_genre";
}
