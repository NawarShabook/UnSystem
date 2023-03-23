<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class StudentReq extends Model
{
    use HasFactory;

    protected $fillable=['firstName',
    'lastName',
    'fatherName',
    'motherName',
    'birthDay',
    'gender',
    'college',
    'section',
    'level',
    'city',
    'phoneNumber',
    'email',
    'user_id'];


    public function user()
    {
        return $this->belongsTo(User::class,'user_id')->where('role', 0);
    }
}
