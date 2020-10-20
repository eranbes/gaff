<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Entry extends Model
{
    use HasFactory;

    protected $table = 'entries';

    protected $fillable = [
        'name',
        'is_app',
        'domain_id',
    ];

    protected $casts = [
        'is_app' => 'boolean',
    ];
}
