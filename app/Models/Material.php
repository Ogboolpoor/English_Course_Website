<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory; // was missing
use Illuminate\Database\Eloquent\Model;

class Material extends Model
{
    use HasFactory;

    protected $fillable = ['title', 'level', 'type', 'content_url'];
}