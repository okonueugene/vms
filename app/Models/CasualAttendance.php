<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CasualAttendance extends Model
{
    use HasFactory;

    protected $fillable = [
        'casual_id',
        'date',
        'clock_in',
        'clock_out',
    ];

    protected $table = 'casual_attendances';

    public function casual()
    {
        return $this->belongsTo(Casual::class);
    }


}
