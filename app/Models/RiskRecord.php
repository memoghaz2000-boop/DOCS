<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RiskRecord extends Model
{
    use HasFactory;

    protected $fillable = [
        'project_id', 'failure_mode', 'severity', 'occurrence', 'detectability',
        'rpn', 'mitigation', 'gate_state', 'risk_owner', 'review_date',
        'severity_adj', 'occurrence_adj', 'detectability_adj', 'rpn_adj'
    ];

    public function project() {
        return $this->belongsTo(Project::class);
    }
}
