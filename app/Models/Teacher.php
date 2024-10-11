<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Teacher extends Model
{ protected $table = 'teacher_subject';
    use HasFactory;
    public function subjects()
    {
        return $this->belongsToMany(Subject::class, 'teacher_subject');
    }

}
