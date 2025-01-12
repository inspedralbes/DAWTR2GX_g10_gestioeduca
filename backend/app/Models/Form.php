<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Form extends Model
{
    protected $fillable = [
        'title',
        'description',
        'division'
    ];

    public function course()
    {
        return $this->belongsToMany(User::class);
    }

    public function divisions()
    {
        return $this->belongsToMany(Division::class);
    }

    public function questions()
    {
        return $this->hasMany(Question::class);
    }
}
