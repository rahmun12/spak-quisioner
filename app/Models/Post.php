<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Post extends Model
{
    protected $fillable = [
        'title',
        'body',
        'admin_id',
        'status',
    ];

    public function admin()
    {
        return $this->belongsTo(Admin::class);
    }
}
