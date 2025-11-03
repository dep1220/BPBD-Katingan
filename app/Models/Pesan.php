<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Pesan extends Model
{
    use HasFactory;
    protected $fillable = [

        'name',
        'email',
        'phone',
        'category',
        'subject',
        'message',
        'is_read',
    ];
}
