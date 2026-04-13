<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Packaging extends Model
{
    use HasFactory;

    protected $fillable = [
        'material_type', 'wvtr_value', 'thickness', 'supplier', 'notes'
    ];
}
