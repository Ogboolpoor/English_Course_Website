<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Lesson extends Model
{
    use HasFactory;

    // This list tells Laravel: "It is safe to save data to these columns"
    protected $fillable = [
        'user_id',
        'lesson_date',
        'lesson_time',
        'homework',
    ];

    // Optional: This helps Laravel know that 'user' belongs to a real User
    public function user()
    {
        return $this->belongsTo(User::class);
    }
}