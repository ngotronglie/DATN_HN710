<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class WorkShift extends Model
{
    use HasFactory;

    protected $table = 'work_shifts';

    protected $fillable = [
        'shift_name',
        'start_time',
        'end_time',
    ];

    public function users()
    {
        return $this->hasMany(User::class, 'work_shifts_id');
    }
}
