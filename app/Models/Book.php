<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Book extends Model
{
    protected $table = 'books';
    protected $primaryKey = 'id';
    protected $fillable = [
        'name',
        'is_active',
        'publication_id',
        'author_id',
        'created_at',
        'updated_at',
    ];
}
