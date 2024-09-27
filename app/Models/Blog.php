<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Blog extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'title',
        'img_avt',
        'content',
        'view',
        'category_blog_id',
        'user_id',
        'is_active'
    ];

    protected $casts =[
        'is_active'=> 'boolean'
    ];

    public function category()
    {
        return $this->belongsTo(CategoryBlog::class, 'category_blog_id');
    }


    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
