<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    const ADMIN_ROLE = 2;
    const STAFF_ROLE = 1;

    protected $fillable = [
        'name',
        'email',
        'address',
        'phone',
        'avatar',
        'password',
        'role',
        'point',
        'is_active',
        'date_of_birth',
        'work_shifts_id',
        'email_verified_at',
        'email_verification_expires_at',
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected $casts = [
        'email_verified_at' => 'datetime',
        'email_verification_expires_at' => 'datetime',
        'password' => 'hashed',
        'is_active' => 'boolean'
    ];

    public function isAdminOrStaff()
    {
        return $this->role == self::ADMIN_ROLE || $this->role == self::STAFF_ROLE;
    }

    public function blogs()
    {
        return $this->hasMany(Blog::class);
    }

    public function banners()
    {
        return $this->hasMany(Banner::class);
    }

    public function vouchers()
    {
        return $this->belongsToMany(Voucher::class, 'user_vouchers')->withPivot('status')->withTimestamps();
    }
    public function staffChats()
    {
        return $this->hasMany(Chat::class, 'staff_id');
    }

    public function userChats()
    {
        return $this->hasMany(Chat::class, 'user_id');
    }

    public function workShift()
    {
        return $this->belongsTo(WorkShift::class, 'work_shifts_id');
    }

}
