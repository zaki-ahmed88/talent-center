<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Exam extends Model
{
    use HasFactory;


    protected $fillable = ['name', 'start', 'end', 'time', 'degree', 'type_id', 'teacher_id', 'group_id', 'is_closed', 'count'];


    public function studentGroups(){

        return $this->hasOne(StudentGroup::class, 'group_id', 'group_id');
    }


    public function examTypes(){
        return $this->belongsTo(ExamType::class, 'type_id', 'id');
    }
}
