<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Casual extends Model
{
    use HasFactory;

    protected $fillable =
    [
      'first_name',
      'last_name',
      'phone',
      'designation',
      'gender',
      'official_identification_number',
      'date_of_joining',
      'status',
      'about',

    ];

    //protected table
    protected $table = 'casuals';
}
