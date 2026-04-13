<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ExperimentResult extends Model
{
    use HasFactory;

    protected $fillable = [
        'experiment_id', 'effervescence_sec', 'f2_worst', 'moisture_pct',
        'cu_rsd_pct', 'measured_pH', 'taste_score', 'appearance_result', 'pass_fail'
    ];

    public function experiment() {
        return $this->belongsTo(Experiment::class);
    }
}
