<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Excipient extends Model
{
    use HasFactory;

    protected $fillable = [
        'excipient_name', 'category', 'mw', 'acid_equivalents', 'base_equivalents',
        'pKa_or_buffer_role', 'typical_lod_pct', 'hygroscopicity_level',
        'cost_per_mg', 'compatibility_flags'
    ];
}
