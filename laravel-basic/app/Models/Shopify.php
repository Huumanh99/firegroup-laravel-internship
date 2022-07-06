<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Shopify extends Model
{
    use HasFactory;
    protected $table = 'shopify';
    protected $fillable = [
        'name',
        'domain',
        'email',
        'shopify_domain',
        'access_token',
        'plan_name',
        'created_at',
    ];
}
