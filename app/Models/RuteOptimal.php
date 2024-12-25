<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RuteOptimal extends Model
{
    use HasFactory;
    protected $table = "rute_optimals";
    protected $fillable = [
        "route", "total_distance", "date_time",
    ];

    public $timestamps = false;
}
