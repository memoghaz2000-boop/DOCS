<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class StabilityRecord extends Model
{
    use HasFactory;

    protected $fillable = [
        'project_id', 'formula_id', 'condition', 'timepoint', 'results', 'trend_flags'
    ];

    public function project() {
        return $this->belongsTo(Project::class);
    }

    public function formula() {
        return $this->belongsTo(Formula::class);
    }
}
