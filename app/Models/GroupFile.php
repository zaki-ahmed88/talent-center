<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class GroupFile extends Model
{
    use HasFactory;




    protected $fillable = ['group_id', 'teacher_id', 'file', 'name'];

    public function getFileAttribute($value){

        return 'https://s3.console.aws.amazon.com/s3/buckets/zaki88?region=eu-central-1&prefix=Group/Files/&showversions=false'.$this->attributes['file'];
    }

}
