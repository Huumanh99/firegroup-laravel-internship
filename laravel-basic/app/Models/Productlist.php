<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Productlist extends Model
{
    use HasFactory;
    protected $table = 'productslist';
    protected $fillable = [
        'id',
        'body_html',
        'title',
        'handle',
        'status',
        'image',
    ];
}
