<?php

namespace App\Services;

use App\Models\Formula;

class FormulaCalculationService
{
    /**
     * حسابات التركيبة بناءً على المكونات
     *
     * @param Formula $formula
     * @return Formula
     */
    public function calculate(Formula $formula): Formula
    {
        $totalAcidContribution = 0;
        $totalBaseContribution = 0;

        foreach ($formula->components as $component) {
            $material = $component->material;

            $mw = $material->mw ?? 0;
            $acidEquivalents = $material->acid_equivalents ?? 0;
            $baseEquivalents = $material->base_equivalents ?? 0;

            // حساب المولات
            $moles = 0;
            if ($mw > 0) {
                $moles = $component->amount_mg / $mw;
            }
            $component->moles = $moles;

            // المساهمة الحمضية والقاعدية
            $acidContribution = $moles * $acidEquivalents;
            $baseContribution = $moles * $baseEquivalents;

            $component->acid_eq_contribution = $acidContribution;
            $component->base_eq_contribution = $baseContribution;
            $component->save();

            // تجميع المساهمات لإجمالي التركيبة
            $totalAcidContribution += $acidContribution;
            $totalBaseContribution += $baseContribution;
        }

        // نسبة الحمض إلى القاعدة
        $ratio = 0;
        if ($totalBaseContribution > 0) {
            $ratio = $totalAcidContribution / $totalBaseContribution;
        }

        $formula->predicted_eq_ratio = $ratio;
        $formula->save();

        return $formula;
    }

    /**
     * التحقق من صحة المدخلات بناءً على QTPP في المشروع
     * 
     * @param Formula $formula
     * @return array
     */
    public function sanityCheck(Formula $formula): array
    {
        $project = $formula->project;
        
        if (!$project || !$project->productProfile) {
            return [
                'is_valid' => false,
                'message' => 'Product Profile (QTPP) is missing for this project.',
            ];
        }

        $productProfile = $project->productProfile;
        
        $compliancePh = $formula->compliance_pH;
        $phLow = $productProfile->pH_low;
        $phHigh = $productProfile->pH_high;

        if (is_null($compliancePh)) {
            return [
                'is_valid' => false,
                'message' => 'Compliance pH is not set for this formula.',
            ];
        }

        if (is_null($phLow) || is_null($phHigh)) {
            return [
                'is_valid' => false,
                'message' => 'pH boundaries (pH_low, pH_high) are not fully defined in the QTPP.',
            ];
        }

        $isValid = ($compliancePh >= $phLow && $compliancePh <= $phHigh);

        return [
            'is_valid' => $isValid,
            'message' => $isValid 
                ? 'Compliance pH is within the acceptable range.' 
                : "Compliance pH ({$compliancePh}) is outside the acceptable range ({$phLow} - {$phHigh}).",
            'compliance_pH' => $compliancePh,
            'pH_low' => $phLow,
            'pH_high' => $phHigh,
        ];
    }
}
