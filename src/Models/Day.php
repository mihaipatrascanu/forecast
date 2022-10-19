<?php

namespace Mihai\Weather\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Day extends Model
{
    use HasFactory;
    public $fillable = [
        'forecat_ip',
        'datetime',
        'temp_max',
        'temp_min'
    ];
    
}
