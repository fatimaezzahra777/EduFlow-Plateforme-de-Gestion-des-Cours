<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Inscription extends Model
{
     protected $fillable = [
        'user_id',
        'course_id',
        'group_id'
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function course()
    {
        return $this->belongsTo(Cours::class);
    }

    public function group()
    {
        return $this->belongsTo(Group::class);
    }
}
