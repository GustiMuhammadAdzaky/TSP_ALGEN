<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MatriksJarak extends Model
{
    use HasFactory;
    protected $table = "matriks_jaraks";
    protected $fillable = [
        "origin_id", "destination_id", "distance"
    ];

    public $timestamps = false;
}
