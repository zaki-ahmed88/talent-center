<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Question extends Model
{
    use HasFactory;

    protected $hidden = ['created_at', 'updated_at', 'exam_id'];

    public  function questionImage(){
        return $this->hasOne(QuestionImage::class, 'question_id', 'id');
    }



    public function answer() {

        return $this->hasOne(SystemAnswer::class, 'question_id', 'id');
    }

}

