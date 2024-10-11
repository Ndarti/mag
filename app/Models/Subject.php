<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Subject extends Model
{protected $table = '_subjects';
    use HasFactory;
    public function teachers()
    {
        return $this->belongsToMany(Teacher::class, 'teacher_subject');
    }

}
