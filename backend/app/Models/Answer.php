<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Answer extends Model
{
    protected $fillable = [
        'answer', 'question_id', 'student_id',
    ];

    public function users() {
        return $this->belongsTo(User::class, 'student_id');
    }

    public function questions() {
        return $this->belongsTo(Question::class);
    }
}
