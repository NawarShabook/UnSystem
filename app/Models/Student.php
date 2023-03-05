<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Student extends Model
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
    'room',
    'phoneNumber',
    'email',];

}
