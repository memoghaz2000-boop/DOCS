<?php

namespace App\Observers;

use App\Models\RiskRecord;
use App\Services\FmeaGateService;
use App\Models\Project;

class RiskRecordObserver
{
    protected FmeaGateService $fmeaService;

    public function __construct(FmeaGateService $fmeaService)
    {
        $this->fmeaService = $fmeaService;
    }

    public function saving(RiskRecord $risk)
    {
        // حساب الـ RPN والتأكد من قواعد التخفيف قبل الحفظ
        $this->fmeaService->calculateRiskRpn($risk);
    }

    public function saved(RiskRecord $risk)
    {
        $this->updateProjectGateState($risk->project_id);
    }

    public function deleted(RiskRecord $risk)
    {
        $this->updateProjectGateState($risk->project_id);
    }

    protected function updateProjectGateState($projectId)
    {
        if (!$projectId) return;

        $project = Project::find($projectId);
        if ($project) {
            // يمكننا تحديد حالة Gate State الشاملة للمشروع بناءً على أعلى Risk Record
            // وإذا كان Project لا يحوي حقل gate_state حالياً، يمكننا تحديث جميع سجلات المخاطر
            // أو تحديث الـ Project نفسه. هنا سنراجع ما إذا كان يُقصد تحديث السجلات أو المشروع.
            
            // بما أن بوابة المشروع هي المعنية، سنقوم بجلب الحالة
            $gateState = $this->fmeaService->evaluateProjectGateState($project);
            
            // لنفترض أن تقييم بوابة المشروع يتم تخزينه في Project أو تحديث الـ Gate State للسجلات
            // سنقوم بتحديث جميع سجلات المخاطر التابعة للمشروع بنفس الحالة ليراها الجميع
            RiskRecord::where('project_id', $project->id)->update(['gate_state' => $gateState]);
        }
    }
}
