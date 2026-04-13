<?php

namespace App\Observers;

use App\Models\Formula;
use App\Services\DecisionEngineService;

class FormulaObserver
{
    protected DecisionEngineService $decisionEngine;

    public function __construct(DecisionEngineService $decisionEngine)
    {
        $this->decisionEngine = $decisionEngine;
    }

    /**
     * تسجيل القرار عند الموافقة على تركيبة أو تغيير حالتها.
     */
    public function updated(Formula $formula)
    {
        if ($formula->isDirty('approval_state') || $formula->isDirty('formula_status')) {
            $changes = [];

            if ($formula->isDirty('approval_state')) {
                $changes[] = "Approval State from [{$formula->getOriginal('approval_state')}] to [{$formula->approval_state}]";
            }
            if ($formula->isDirty('formula_status')) {
                $changes[] = "Formula Status from [{$formula->getOriginal('formula_status')}] to [{$formula->formula_status}]";
            }

            $rationale = "Formula Update: " . implode(' and ', $changes);

            // توثيق التغيير في جدول القرارات
            if ($formula->project) {
                $this->decisionEngine->recordDecision(
                    $formula->project,
                    'Formula Approval Transition',
                    $rationale,
                    "Formula ID: {$formula->id}"
                );
            }
        }
    }
}
