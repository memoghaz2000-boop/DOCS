<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Formula extends Model
{
    use HasFactory;

    protected $fillable = [
        'project_id', 'formula_code', 'formula_status', 'target_fill_weight_mg',
        'actual_fill_weight_mg', 'predicted_eq_ratio', 'predicted_pH_raw',
        'compliance_pH', 'predicted_co2_ml', 'predicted_cost_per_unit', 'approval_state'
    ];

    public function project() {
        return $this->belongsTo(Project::class);
    }

    public function components() {
        return $this->hasMany(FormulaComponent::class);
    }
}
