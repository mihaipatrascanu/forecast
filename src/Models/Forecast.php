<?php

namespace Mihai\Weather\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Forecast extends Model
{
    use HasFactory;
    public $fillable = [
        'ip',
        'datetime',
        'day_id'
    ];
}
