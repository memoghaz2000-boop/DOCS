<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DecisionRecord extends Model
{
    use HasFactory;

    protected $fillable = [
        'project_id', 'decision_type', 'rationale', 'linked_evidence'
    ];

    public function project() {
        return $this->belongsTo(Project::class);
    }
}
