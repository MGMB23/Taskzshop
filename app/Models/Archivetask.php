<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Archivetask extends Model
{
    use HasFactory;
    protected $table = 'archivetasks';
    protected $casts = [
        'users' => 'array',
    ];
    protected $fillable = [
        'Name','Description','completed','prize','users'
    ];
}
