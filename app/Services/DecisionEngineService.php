<?php

namespace App\Services;

use App\Models\Project;
use App\Models\DecisionRecord;
use Illuminate\Support\Facades\Auth;
use Exception;

class DecisionEngineService
{
    public const STATUS_DEV_PASS = 'Development PASS';
    public const STATUS_RELEASE_READY = 'Release READY';
    public const STABILITY_STABLE = 'STABLE';

    /**
     * تقييم ما إذا كان المشروع جاهزاً للإصدار بناءً على القواعد الصارمة.
     *
     * @param Project $project
     * @return bool
     * @throws Exception
     */
    public function validateReleaseReadiness(Project $project, string $originalStatus): bool
    {
        // الشرط الأول: لابد أن يكون المشروع قد حقق نجاح التطوير أولاً.
        if ($originalStatus !== self::STATUS_DEV_PASS) {
            throw new Exception("لا يمكن ترقية المشروع إلى حالة 'جاهزية الإصدار' (Release READY) قبل أن يحصل على 'نجاح التطوير' (Development PASS) كحالة سابقة.");
        }

        // الشرط الثاني: التحقق من حالة دراسة الاستقرار الإجمالية
        // بناءً على قواعد EDOS، نفحص مدى استقرار المشروع
        $overallStability = $this->getOverallStabilityStatus($project);
        
        if ($overallStability !== self::STABILITY_STABLE) {
            throw new Exception("لا يمكن الترقية. يجب أن تكون حالة الاستقرار الإجمالية للمشروع هي (STABLE). الحالة الحالية: $overallStability");
        }

        return true;
    }

    /**
     * حسابحالة الاستقرار الإجمالية للمشروع بناءً على دراسات الاستقرار
     *
     * @param Project $project
     * @return string
     */
    public function getOverallStabilityStatus(Project $project): string
    {
        // إذا كان هناك حقل مخصص في جدول Project لاسم overall_stability_status نستخدمه:
        if (isset($project->overall_stability_status)) {
            return strtoupper($project->overall_stability_status);
        }

        // إن لم يكن، يتم الحساب ديناميكياً بناءً على سجلات الاستقرار (StabilityRecords)
        $records = $project->stabilityRecords;
        
        if ($records->isEmpty()) {
            return 'NO_DATA';
        }

        // نقوم بفحص السجلات، في حال كان هناك أي نتيجة سلبية أو أعلام ترند غير مستقرة، لا يكون مستقراً
        foreach ($records as $record) {
            $trend = strtolower($record->trend_flags ?? '');
            $results = strtolower($record->results ?? '');
            
            if (str_contains($trend, 'fail') || str_contains($trend, 'out of spec') || str_contains($trend, 'unstable') || 
                str_contains($results, 'fail')) {
                return 'UNSTABLE';
            }
        }

        return self::STABILITY_STABLE;
    }

    /**
     * توثيق أي قرار مفصلي في نظام تسجيل القرارات كمسار للتدقيق (Audit Traceability)
     *
     * @param Project $project
     * @param string $decisionType
     * @param string $rationale
     * @param string|null $evidence
     * @return DecisionRecord
     */
    public function recordDecision(Project $project, string $decisionType, string $rationale, ?string $evidence = null): DecisionRecord
    {
        $userId = Auth::id() ?? 1; // كمثال افتراضي للتدقيق
        $userName = Auth::user() ? Auth::user()->name : 'System/API';

        // إضافة اسم المستخدم أو مرجع متخذ القرار ضمن الـ Rationale أو في حقل مخصص
        $fullRationale = "Made By [{$userName}]: " . $rationale;

        return DecisionRecord::create([
            'project_id' => $project->id,
            'decision_type' => $decisionType,
            'rationale' => $fullRationale,
            'linked_evidence' => $evidence,
        ]);
    }
}
