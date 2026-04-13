<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Project extends Model
{
    use HasFactory;

    protected $fillable = [
        'project_code', 'project_name', 'api_id', 'dosage_form', 'development_stage',
        'reference_product', 'target_market', 'project_status', 'owner'
    ];

    public function api() {
        return $this->belongsTo(Api::class);
    }

    public function productProfile() {
        return $this->hasOne(ProductProfile::class);
    }

    public function formulas() {
        return $this->hasMany(Formula::class);
    }

    public function experiments() {
        return $this->hasMany(Experiment::class);
    }

    public function riskRecords() {
        return $this->hasMany(RiskRecord::class);
    }

    public function stabilityRecords() {
        return $this->hasMany(StabilityRecord::class);
    }

    public function decisionRecords() {
        return $this->hasMany(DecisionRecord::class);
    }
}
