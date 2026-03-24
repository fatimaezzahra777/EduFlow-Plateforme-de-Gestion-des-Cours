<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Cours extends Model
{
    protected $fillable = [
        'titre',
        'description',
        'prix',
        'teacher_id'
    ];

    public function teacher()
    {
        return $this->belongsTo(User::class, 'teacher_id');
    }

    public function inscription()
    {
        return $this->hasMany(Inscription::class);
    }

    public function groups()
    {
        return $this->hasMany(Group::class);
    }

    public function favorites()
    {
        return $this->hasMany(Favorite::class);
    }
}
