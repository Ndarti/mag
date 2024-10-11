<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Group extends Model
{protected $table = '_Group';
    public $timestamps = false;
    public function isNotEmpty(): bool
    {
        return $this->count() > 0;
    }
    use HasFactory;
}
