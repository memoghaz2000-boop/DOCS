<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Experiment extends Model
{
    use HasFactory;

    protected $fillable = [
        'project_id', 'formula_id', 'experiment_type', 'experiment_code',
        'batch_size', 'equipment_used', 'process_route', 'objective', 'run_status'
    ];

    public function project() {
        return $this->belongsTo(Project::class);
    }

    public function formula() {
        return $this->belongsTo(Formula::class);
    }

    public function results() {
        return $this->hasMany(ExperimentResult::class);
    }
}
