<?php

namespace App\Services;

use App\Models\Project;
use App\Models\RiskRecord;
use Exception;

class FmeaGateService
{
    /**
     * حساب وتقييم وتحديث بوابة المخاطر (FMEA Gate) للمشروع
     * تعتمد الحالة على أعلى قيمة RPN معدلة (RPN_adj)
     *
     * @param Project $project
     * @param int $threshold الحد الأقصى المقبول لـ RPN قبل أن تعتبر البوابة "فاشلة"
     * @return string
     */
    public function evaluateProjectGateState(Project $project, ?int $threshold = null): string
    {
        $threshold = $threshold ?? config('fmea.gate_threshold', 150);
        $maxRpnAdj = $project->riskRecords()->max('rpn_adj') ?? 0;

        // إذا كان أعلى RPN معدل يتجاوز الحد المسموح، تفشل البوابة
        $gateState = $maxRpnAdj > $threshold ? 'Fail' : 'Pass';

        // يمكن حفظ حالة بوابة المخاطر في المشروع إذا كان هناك حقل لذلك،
        // أو إرجاع القيمة لاستخدامها.
        // نفترض هنا إرجاع النص فقط ليُعرض أو يُحفظ حسب الحاجة.
        return $gateState;
    }

    /**
     * حساب RPN بصيغته الخام والمعدلة مع مراعاة قواعد التخفيف (Mitigation)
     *
     * @param RiskRecord $risk
     * @return RiskRecord
     * @throws Exception
     */
    public function calculateRiskRpn(RiskRecord $risk): RiskRecord
    {
        // 1. حساب الـ RPN الخام
        $risk->rpn = ($risk->severity ?? 1) * ($risk->occurrence ?? 1) * ($risk->detectability ?? 1);

        // 2. تطبيق القواعد على الـ RPN المعدل (بعد خطة التخفيف)
        if ($risk->severity_adj !== null || $risk->occurrence_adj !== null || $risk->detectability_adj !== null) {
            
            // القاعدة الأولى: لا يمكن تغيير الخطورة (Severity) بحرية، فهي ثابتة غالباً حتى مع التخفيف
            // إلا إذا كان التخفيف يغير التصميم الجذري، ولكن حسب الطلب لا يُسمح بتعديلها بحرية.
            if ($risk->severity_adj !== null && $risk->severity_adj !== $risk->severity) {
                // نجبر الخطورة المعدلة على أن تساوي الخطورة الأصلية أو نلغي التعديل
                $risk->severity_adj = $risk->severity;
            } else {
                $risk->severity_adj = $risk->severity; 
            }

            // القاعدة الثانية: يُسمح بتخفيض الحدوث والاكتشاف فقط إذا كان هناك خطة تخفيف واضحة
            $hasMitigation = !empty(trim($risk->mitigation));

            if (!$hasMitigation) {
                if (($risk->occurrence_adj !== null && $risk->occurrence_adj < $risk->occurrence) || 
                    ($risk->detectability_adj !== null && $risk->detectability_adj < $risk->detectability)) {
                    throw new Exception("لا يمكن تخفيض تقييمات الحدوث (Occurrence) أو الاكتشاف (Detectability) دون توفير خطة تخفيف (Mitigation) واضحة.");
                }
            }

            // ضمان استخدام القيم الأصلية إذا لم يتم إدخال قيم معدلة بديلة (أو إذا لم يكن التخفيض مسموحاً)
            $occ_adj = $risk->occurrence_adj ?? $risk->occurrence;
            $det_adj = $risk->detectability_adj ?? $risk->detectability;

            $risk->rpn_adj = $risk->severity_adj * $occ_adj * $det_adj;
        } else {
            // إذا لم تكن هناك قيم معدلة مدخلة، فإن المعدل يساوي الخام
            $risk->rpn_adj = $risk->rpn;
            $risk->severity_adj = $risk->severity;
            $risk->occurrence_adj = $risk->occurrence;
            $risk->detectability_adj = $risk->detectability;
        }

        return $risk;
    }
}
