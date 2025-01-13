<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Form extends Model
{

    protected $fillable = [
        'title',
        'description',
        'status',
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

    public function users()
    {
        return $this->belongsToMany(User::class, 'form_user', 'form_id', 'user_id');
    }

}
