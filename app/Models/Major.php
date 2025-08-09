<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Major extends Model
{
    protected $fillable = ['code','name','description','tags','is_active'];

    protected $casts = [
        'tags' => 'array',
        'is_active' => 'boolean',
    ];
}
