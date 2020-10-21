<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Crawl extends Model
{
    use HasFactory;

    protected $fillable = [
        'domain_id',
        'is_app',
        'entry_name',
        'status_id',
    ];

    protected $casts = [
        'is_app' => 'boolean',
    ];
}
