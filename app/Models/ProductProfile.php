<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProductProfile extends Model
{
    use HasFactory;

    protected $fillable = [
        'project_id', 'strength_mg', 'fill_weight_target_mg', 'target_effervescence_sec',
        'target_pH', 'pH_low', 'pH_high', 'target_f2_min', 'max_moisture_pct',
        'max_cu_rsd_pct', 'rh_limit_pct'
    ];

    public function project() {
        return $this->belongsTo(Project::class);
    }
}
