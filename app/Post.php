<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Post extends Model
{
    protected $fillable = [
        'title',
        'content',
        'category_id',
        'created_at',
        'update_at',
        'created_by'
    ];


    public function user()
    {
        return $this->belongsTo(User::class,'created_by','id');
    }
}
