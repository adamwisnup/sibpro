<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class StudentClass extends Model
{
    protected $table = "student_classes";
    protected $fillable = [
        'uuid',
        'class_name',
    ];

    public function users()
    {
        return $this->hasMany(User::class, 'class_id');
    }
}
