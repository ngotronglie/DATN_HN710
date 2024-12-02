<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\User;

class Message extends Model
{
    use HasFactory;
    protected $table = 'messages';

    public $fillable = [
        'content',
        'room_id',
        'user_send_id'
    ];

    public function userSend(){
        return $this->belongsTo(User::class, 'user_send_id');
    }
}