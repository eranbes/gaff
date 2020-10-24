<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Domain extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'ns_ads',
        'ns_app_ads',
        'publisher_id',
    ];

    protected $casts = [
        'ns_ads' => 'boolean',
        'ns_app_ads' => 'boolean',
    ];

    public function entries()
    {
        return $this->hasMany('App\Models\Entry');
    }

    public function assets()
    {
        return $this->hasMany('App\Models\Asset');
    }
}
