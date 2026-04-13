# دليل المطور التقني لنظام EDOS
**(Developer Documentation & Architecture Guide)**

هذا الدليل مخصص للمبرمجين لفهم البنية التحتية، المعمارية المتبعة، وسير العمل التقني داخل نظام **EDOS** المطور بإطار عمل Laravel وواجهة Filament.

---

## 🏗️ 1. المعمارية العامة (Architecture Overview)
يعتمد النظام على نمط **MVC (Model-View-Controller)** مُعزّز بمبدأ **"Thin Controllers, Fat Services"**.
* **الواجهات الأمامية:** مُدارة بكامل أجزائها عبر حزم **Filament PHP**.
* **طبقة البيانات (Models):** تعتمد على نظام الـ Eloquent ORM.
* **طبقة المنطق (Services):** حيث تتمركز جميع الحسابات المعقدة وقوانين الصناعة الدوائية (QbD) لتكون قابلة لإعادة الاستخدام في الواجهة الأمامية أو في الـ APIs لاحقاً.
* **مراقبو الأحداث (Observers):** لالتقاط التغييرات الدقيقة وتدوين سجلات الامتثال (Audit Trails) أوتوماتيكياً.

---

## 🗄️ 2. هيكلة قاعدة البيانات والعلاقات (Database & Models)
النظام **Project-Centric** (مركزي حول نماذج المشاريع)، وتم بناء العلاقات في `app/Models` كالتالي:
* **`Project`**: النموذج الأب المحوري (`hasOne: ProductProfile`, `hasMany: Formula, RiskRecord, Experiment, StabilityRecord, DecisionRecord`).
* **`Formula`**: ترتبط بالـ `Project` وتملك `hasMany: FormulaComponent`.
* **`FormulaComponent`**: تتميز بعلاقة مبنية على **Polymorphism** (`morphTo`) باسم `material()` لتستدعي المكونات بمرونة سواءً كانت من جدول `apis` (للمادة الفعالة) أو جدول `excipients` (للسواغات).
* **`RiskRecord`**: يتبع المشروع، ويخزن الـ FMEA مع الحقول المعدلة `_adj`.

*نصيحة تطويرية:* التزم دائماً باستدعاء العلاقات داخل الاستعلامات (Eager Loading) مثل `Project::with('productProfile')` لتفادي مشكلة (N+1 queries) نظراً للضخامة المتوقعة لبيانات التركيبات.

---

## ⚙️ 3. طبقة الخدمات المبرمجة والمنطق (Services Layer)
مكانها: `app/Services/` وهي العقل المدبر للنظام:

1. **`FormulaCalculationService`**: 
   - **المهمة:** معالجة الاستعلام qryFormulaCalc و qryFormulaSanityCheck.
   - **الدوال:** 
     - `calculate()` لحساب (Moles = mg / mw) والمكافئات وحفظ (Acid/Base ratio). 
     - `sanityCheck()` للتحقق من توافق `compliance_pH` مع نطاق الـ QTPP المدرج بالمشروع.
2. **`FmeaGateService`**: 
   - **المهمة:** معالجة الاستعلام qryFMEAGate.
   - **الدوال:** تحسب `rpn_adj`. وتُقيّم بوابة المشروع وتمنع برمجياً أي تغيير مستقل للمخاطر دون وجود خطة التخفيف (`mitigation`).
3. **`DecisionEngineService`**: 
   - **المهمة:** شرط الامتثال وبوابة الإطلاق.
   - **الدوال:** تمنع ترقية الـ Project لحالة `Release READY` إن لم يكن `Development PASS` أو إذا كانت بيانات `getOverallStabilityStatus()` لا تساوي `STABLE`. وتقوم بكتابة قرار في `DecisionRecord`.

---

## 👁️ 4. مراقبو الأحداث (Laravel Observers)
الـ Observers تعطي النظام القوة لردع الأخطاء في الخلفية، متموضعة في `app/Observers`، وتم تسجيلها في مسار `AppServiceProvider::boot`:
1. **`RiskRecordObserver`:** يتم استدعاء خدمتـها قبل الحفظ `saving` لضمان صحة القيم المحسوبة، وبعده `saved` لتحديث حالة Gate للمشروع تلقائياً.
2. **`ProjectObserver`:** يتدخل عند التحديث `updating` لتفعيل حراس الامتثال (Compliance Gates) ورمي الاستثناء `Exception` إذا لزم، ويكتب التوثيق في `updated`.
3. **`FormulaObserver`:** مختص برصد حالات التركيبة والموافقة عليها وإنزالها لجدول `decision_records`.

---

## 🖥️ 5. واجهات Filament والتفاعلات اللحظية (Filament Resources)
موجودة في مسار: `app/Filament/Resources`
تم تقسيم الواجهات إلى مجموعات (Navigation Groups) لتسهيل الوصول:
* **Laboratory:** يحتوي على مساحة (DOE Workspace) للتجارب الإحصائية، الاستقرار (StabilityRecords)، والتجارب العملية.
* **Compliance & Audit:** يحتوي على (Decision Records) كواجهة فقط للقراءة وأدوات التدقيق والمخاطر.
* **Master Data:** لبيانات التغليف الحرجة (Packaging)، والأدوية، والسواغات.

أهم تقنياتنا المستخدمة داخل الفورم (Schemas):
* **التحديث اللحظي (`live()`):** استخدمنا دالة `->live()` ضمن حقول الـ `Severity` وغيرها ليتم تحديث الناتج واستشعار محتوى الـ `Mitigation` قبل كبس زر الحفظ (كما في `RiskRecordForm.php`).
* **قواعد التحقق المخصصة المتقدمة (Custom Rules):** لتطبيق قواعدنا الصارمة على الواجهة فوراً. مثال: استخدمنا دالة الـ `Closure` بداخل حقل `occurrence_adj` لمنع أي قيمة تقل عن القيمة الأصلية بدون أن يتم تعبئة حقل (التخفيف - Mitigation).

## 🛠️ 6. كيف تطور في النظام مستقبلاً؟
لإضافة ميزة أو نموذج جديد، إتبع سير العمل (Workflow) التالي ليبقى الكود نظيفاً:
1. أنشئ الـ Model وملفات التهجير (Migrations).
2. عرّف العلاقات بدقة في الـ Model الجديد.
3. **حاسب نفسك من أين يبدأ المنطق؟** إذا كان هناك قواعد بيانات محسوبة أو معقدة -> **اكتب Service جديدة** في `app/Services`.
4. أنشئ (Filament Resource) باستخدام الأمر `php artisan make:filament-resource ModelName`.
5. قم بتمرير الخدمة المعقدة الخاصة بك داخل الـ `afterStateUpdated` للحقول بـ Filament، أو ارمِ التقييد عبر `Observer` يسهر على قاعدة البيانات بالخلفية لعدم السماح للـ API أو الـ Seeder بتجاهله.

---
*تمت كتابة وتوثيق هذا المعمار البرمجي لمساعدتك في التوسع بأمان، حظاً موفقاً في التطوير!*
