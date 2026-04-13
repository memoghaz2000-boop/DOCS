<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Project;
use App\Models\Api;
use App\Models\ProductProfile;
use App\Models\Excipient;
use App\Models\Formula;
use App\Models\FormulaComponent;
use App\Services\FormulaCalculationService;

class FamotidineSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // 1. إنشاء المادة الفعالة (API)
        $api = Api::firstOrCreate([
            'name' => 'Famotidine'
        ], [
            'description' => 'H2 blocker used to treat and prevent ulcers in the stomach and intestines.'
        ]);

        // 2. إنشاء المشروع (Project) كأصل للعلاقات
        $project = Project::firstOrCreate([
            'project_code' => 'FAM-EFF-001'
        ], [
            'project_name' => 'Famotidine 20mg Effervescent Tablets',
            'api_id' => $api->id,
            'dosage_form' => 'Effervescent Tablet',
            'development_stage' => 'Formulation',
            'project_status' => 'In Progress'
        ]);

        // 3. المواصفات المستهدفة للمنتج (QTPP - Product Profile)
        ProductProfile::updateOrCreate([
            'project_id' => $project->id
        ], [
            'strength_mg' => 20,
            'fill_weight_target_mg' => 5000.00,
            'pH_low' => 5.0,
            'pH_high' => 6.5,
            'target_pH' => 5.8,
            'target_effervescence_sec' => 120, // 2 minutes max
        ]);

        // 4. إعداد المواد السواغة (Excipients) اللازمة للتفاعل الفوار
        $citricAcid = Excipient::firstOrCreate([
            'excipient_name' => 'Citric Acid Anhydrous'
        ], [
            'category' => 'Acid Source',
            'mw' => 192.12,
            'acid_equivalents' => 3,
            'base_equivalents' => 0
        ]);

        $sodiumBicarbonate = Excipient::firstOrCreate([
            'excipient_name' => 'Sodium Bicarbonate'
        ], [
            'category' => 'Base Source',
            'mw' => 84.00,
            'acid_equivalents' => 0,
            'base_equivalents' => 1
        ]);

        $sorbitol = Excipient::firstOrCreate([
            'excipient_name' => 'Sorbitol'
        ], [
            'category' => 'Binder/Diluent',
            'mw' => 182.17,
            'acid_equivalents' => 0,
            'base_equivalents' => 0
        ]);

        // 5. إنشاء مسودة تركيبة (Formula)
        $formula = Formula::create([
            'project_id' => $project->id,
            'formula_code' => 'FAM-F01',
            'formula_status' => 'Draft',
            'target_fill_weight_mg' => 5000.00,
            'compliance_pH' => 5.5, // قيمة افتراضية لتنجح في اختبار Sanity Check
        ]);

        // إضافة المادة الفعالة
        FormulaComponent::create([
            'formula_id' => $formula->id,
            'material_id' => $api->id,
            'material_type' => Api::class,
            'role_in_formula' => 'Active',
            'amount_mg' => 20.00,
            'is_critical_component' => true
        ]);

        // إضافة المصدر الحمضي 
        FormulaComponent::create([
            'formula_id' => $formula->id,
            'material_id' => $citricAcid->id,
            'material_type' => Excipient::class,
            'role_in_formula' => 'Acid Source',
            'amount_mg' => 2000.00, // 2000 mg / 192.12 = 10.41 moles => 31.23 acid eq
            'is_critical_component' => true
        ]);

        // إضافة المصدر القاعدي 
        FormulaComponent::create([
            'formula_id' => $formula->id,
            'material_id' => $sodiumBicarbonate->id,
            'material_type' => Excipient::class,
            'role_in_formula' => 'Base Source',
            'amount_mg' => 2547.00, // 2547 mg / 84.00 = 30.32 moles => 30.32 base eq
            'is_critical_component' => true
        ]);

        // إضافة المادة الرابطة للتكملة (20 + 2000 + 2547 = 4567) الباقي 433 مغ
        FormulaComponent::create([
            'formula_id' => $formula->id,
            'material_id' => $sorbitol->id,
            'material_type' => Excipient::class,
            'role_in_formula' => 'Binder',
            'amount_mg' => 433.00,
            'is_critical_component' => false
        ]);

        // 6. تفعيل خدمة الحسابات (Calculation Service) لاختبار المنطق البرمجي فعلياً
        $calcService = new FormulaCalculationService();
        $calcService->calculate($formula);

        // نسبة الحمض/القاعدة المحسوبة ستكون (31.23 / 30.32) = تقريباً 1.03
    }
}
