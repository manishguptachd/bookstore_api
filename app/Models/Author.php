<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Author extends Model
{
    protected $table = 'authors';
    protected $primaryKey = 'id';
    protected $fillable = [
        'name',
        'is_active',
        'api_token',
        'created_at',
        'updated_at',
    ];


}
