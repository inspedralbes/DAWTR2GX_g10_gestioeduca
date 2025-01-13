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

    public function course() {
        return $this->belongsToMany(User::class, 'course_user', 'form_id', 'user_id');
    }

    public function divisions(){
        return $this->belongsToMany(Division::class, 'division_form', 'form_id', 'division_id');
    }

    public function questions()
    {
        return $this->hasMany(Question::class);
    }

    public function answers()
    {
        return $this->hasMany(Answer::class, Question::class);
    }
}
