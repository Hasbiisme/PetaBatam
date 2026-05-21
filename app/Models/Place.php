<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Place extends Model
{
    use HasFactory;

    protected $fillable = [
    'name',
    'address',
    'latitude',
    'longitude',
    'category',
    'subcategory',
    'cluster',
    'visit_duration',
    'image'
    ];
}
