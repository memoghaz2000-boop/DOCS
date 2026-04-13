<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class FormulaComponent extends Model
{
    use HasFactory;

    protected $fillable = [
        'formula_id', 'material_id', 'material_type', 'role_in_formula',
        'amount_mg', 'moles', 'acid_eq_contribution', 'base_eq_contribution',
        'cost_contribution', 'is_critical_component'
    ];

    public function formula() {
        return $this->belongsTo(Formula::class);
    }

    public function material() {
        return $this->morphTo();
    }
}
