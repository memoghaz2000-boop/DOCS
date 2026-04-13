<?php

namespace App\Observers;

use App\Models\Project;
use App\Services\DecisionEngineService;
use Exception;

class ProjectObserver
{
    protected DecisionEngineService $decisionEngine;

    public function __construct(DecisionEngineService $decisionEngine)
    {
        $this->decisionEngine = $decisionEngine;
    }

    /**
     * قبل الحفظ والتعديل، نطبق القيود (Gates) الخاصة بنظام المشاريع
     */
    public function updating(Project $project)
    {
        // التحقق مما إذا كان هناك تغيير في حالة المشروع
        if ($project->isDirty('project_status')) {
            $newStatus = $project->project_status;
            $oldStatus = $project->getOriginal('project_status');

            // إذا أردنا الانتقال لحالة 'Release READY' نطبق قوانين القرار الصارمة
            if ($newStatus === DecisionEngineService::STATUS_RELEASE_READY) {
                $this->decisionEngine->validateReleaseReadiness($project, $oldStatus);
            }
        }
    }

    /**
     * بعد الحفظ الناجح، نقوم بإنشاء سجل في جدول القرارات (Audit Trail)
     */
    public function updated(Project $project)
    {
        // توثيق التغييرات المحورية كقرارات
        if ($project->isDirty('project_status')) {
            $newStatus = $project->project_status;
            $oldStatus = $project->getOriginal('project_status');

            $rationale = "Project status automatically transitioned from [{$oldStatus}] to [{$newStatus}].";
            
            $this->decisionEngine->recordDecision(
                $project,
                'Status Transition',
                $rationale,
                "Project ID: {$project->id}"
            );
        }
    }
}
