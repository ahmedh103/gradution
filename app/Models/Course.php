<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Course extends Model
{
    use HasFactory;


    protected $fillable = [
        'title',
        'description',
        'images',
        'instructor_id'
    ];

    public function users()
    {
        return $this->belongsToMany('App\Models\User','course_student');
    }



    public function instructor()
    {
        return $this->belongsTo('App\Models\Instructor');
    }
}
