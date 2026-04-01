<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Group extends Model
{
     protected $fillable = ['course_id'];

     public function course()
     {
        return $this->belongsTo(Course::class);
     }

    public function inscriptions()
    {
        return $this->hasMany(Inscription::class);
    }
}
