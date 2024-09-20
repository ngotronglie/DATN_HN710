<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Blog extends Model
{
    use HasFactory, SoftDeletes; // Sử dụng HasFactory và SoftDeletes

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'title', 'slug', 'content', 'is_active', 'view', 'user_id',
    ];

    // /**
    //  * The attributes that should be cast to native types.
    //  *
    //  * @var array
    //  */
    // protected $casts = [
    //     'is_active' => 'boolean',
    //     'view' => 'integer',
    // ];

    // /**
    //  * Get the user that owns the blog.
    //  */
    // public function user()
    // {
    //     return $this->belongsTo(User::class);
    // }
}