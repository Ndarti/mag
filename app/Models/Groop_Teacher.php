<?php

namespace App\Models;

use Cassandra\Cluster\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Groop_Teacher extends Model
{ protected $table = 'group__teachers';
    use HasFactory;
    public function groop_teacher()
    {
        return $this->belongsToMany(Subject::class, '__group_teacher');
    }

}
