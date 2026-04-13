# المرجع البرمجي الشامل لنظام EDOS
**(EDOS Codebase Reference & Step-by-Step Breakdown)**

هذا الملف يوثق بتفصيل دقيق كل خطوة برمجية وكل ملف تم إنشاؤه أو تعديله خلال بناء النسخة الأولية (MVP) والمحركات المركزية. تم تقسيم الملفات حسب طبقات المعمارية للرجوع إليها بكل سهولة.

---

## 1. طبقة قواعد البيانات (Migrations & Seeders)

### أ. ملفات التهجير (Migrations)
* `database/migrations/*_add_adjusted_fmea_fields_to_risk_records_table.php`
  * **الهدف:** إضافة حقول التقييم المعدل (Adjusted FMEA) وهي: `severity_adj`, `occurrence_adj`, `detectability_adj`, `rpn_adj`.
* `database/migrations/*_create_packagings_table.php`
  * **الهدف:** إنشاء جدول `packagings` للاحتفاظ ببيانات مواد التغليف وخصائص منع الرطوبة `wvtr_value`.

### ب. ملفات زرع البيانات (Seeders)
* `database/seeders/FamotidineSeeder.php`
  * **الهدف:** إنشاء مشروع "Famotidine 20mg" كنموذج (MVP). يحوي الكود منطق بناء تركيبة بوزن مستهدف 5000 مجم واستخدام حمض الستريك وبيكربونات الصوديوم لتحقيق نسبة Acid/Base Ratio مبرمجة مسبقاً لتكون `1.03`.
* `database/seeders/DatabaseSeeder.php`
  * **تعديل:** قمنا بتسجيل `FamotidineSeeder` داخله ليعمل عند تنفيذ أمر `db:seed`.

---

## 2. طبقة النماذج (Models)

* `app/Models/FormulaComponent.php`
  * **التعديل:** إضافة وظيفة `material()` كعلاقة متعددة الأوجه (Polymorphic `morphTo`). هذا يسمح لمكون التركيبة بأن يكون إما مادة فعالة (API) أو سواغاً (Excipient).
* `app/Models/RiskRecord.php`
  * **التعديل:** إضافة الحقول الجديدة (مثل `rpn_adj`) لمصفوفة الـ `$fillable` للسماح بحفظها دفعة واحدة (Mass Assignment).
* `app/Models/Packaging.php`
  * **الهدف:** نموذج جديد تماماً يدير جدول مواد التغليف.

---

## 3. طبقة الخدمات المبرمجة والمنطق (Services Layer)

تمثل هذه الطبقة "العقل المدبر" للنظام لتطبيق المعادلات الصيدلانية، وتتضمن:

* `app/Services/FormulaCalculationService.php`
  * **المنطق المبرمج:** 
    1. تمرير `Formula` ليقوم بالمرور الدائري (loop) على المكونات.
    2. حساب عدد المولات (M) بتجنب القسمة على صفر: الحجم بالمليجرام / الوزن الجزيئي.
    3. حساب تأثير الحمض والقاعدة بضرب المولات في أرقام المكافئات.
    4. قسمة الإجمالي لحساب حقل `predicted_eq_ratio`.
    5. وظيفة `sanityCheck` التي تتأكد أن حقل الـ `pH` متوافق مع مجال الـ `QTPP` المرتبط بالمشروع.
* `app/Services/FmeaGateService.php`
  * **المنطق المبرمج:**
    1. دالة التقييم الشامل تمنع نقل بوابة المشروع إذا كان أقصى RPN_adj يتخطى `150`.
    2. تمنع برمجياً تغيير `severity_adj` وتجبره على أخذ القيمة الأصلية للـ `severity`.
    3. ترمي خطأ فادح (Exception) لو تم اكتشاف محاولة إنقاص رقم "الاكتشاف" أو "الحدوث" بينما حقل `mitigation` (خطة التخفيف) فارغ!
* `app/Services/DecisionEngineService.php`
  * **المنطق المبرمج:**
    1. منع انتقال المشروع لـ (Release Ready) إذا لم يكن حقق (Development Pass).
    2. استدعاء وظيفة الحساب الديناميكي `getOverallStabilityStatus` للبحث داخل جدول (`StabilityRecords`). إذا وجدت أية حالة `FAIL` توقِف الإطلاق.
    3. وظيفة `recordDecision` لكتابة قيد التدقيق واسم المستخدم بشكل آلي لجدول الـ Decision Records.

---

## 4. طبقة مراقبة الأحداث (Observers)

هذه الملفات تراقب الحفظ في قواعد البيانات لتنفيذ السيرفيس بشكل تلقائي:

* `app/Observers/RiskRecordObserver.php`
  * يستدعي دالة من `FmeaGateService` لحساب RPN قبل الحفظ المباشر `saving`.
  * يقوم بتحديث Gate State العام للمشروع عند أي عملية `saved` أو `deleted`.
* `app/Observers/ProjectObserver.php`
  * يلتقط عملية تعديل حالة المشروع `updating` ويستدعي وظيفة `validateReleaseReadiness`. إذا رمت الدالة Exception، يتم إجهاض الموافقة.
* `app/Observers/FormulaObserver.php`
  * يحمي قرارات الموافقة على التركيبة بإرسال التغييرات القديمة والجديدة لجدول القرار عبر `recordDecision`.
* `app/Providers/AppServiceProvider.php`
  * **التعديل:** قمنا بتسجيل كافة الـ Observers بداخل دالة `boot()` لتعمل مع بداية تشغيل التطبيق.

---

## 5. الإعدادات (Configuration)

* `config/fmea.php`
  * **الهدف:** بناء ملف مخصص يحتفظ برقم الحد الأقصى لبوابة المخاطر `gate_threshold`. صُمم ليستقي الرقم من البيئة `.env` ليسهل على المستخدم العادي تغييره من `FMEA_GATE_THRESHOLD=150` دون المساس بالأكواد.

---

## 6. واجهات لوحة التحكم (Filament Resources & Pages)

* `app/Filament/Resources/RiskRecords/Schemas/RiskRecordForm.php`
  * **البرمجة المحورية هنا:** تم بناء قسم `Adjusted Risk Assessment`. وضعت حقول تُحدّث لحظياً `live()`، وتم برمجة قاعدة متطورة `Closure Rule` تقرأ قيمة الـ Occurrence الأصلية، وإذا قلّت النسبة المکتوبة تحتها، تفحص متغيراً آخر (Mitigation)، فإن كان الميتيجيسن فارغاً ترسل نص Validation Error وتمنع الحفظ.
* `app/Filament/Resources/DecisionRecordResource.php` و ملفات `Pages` الخاصة بها.
  * **الهدف:** واجهة استعراض لسجلات القرارات. الميزة: وضعنا المتغيرات بوضعية الإغلاق `disabled()` وإلغاء صلاحية الإنشاء اليدوي لضمان نزاهة تدقيق الـ Compliance. 
* `app/Filament/Resources/StabilityRecordResource.php` و ملفاتها
  * **الهدف:** إدارة دراسات الثبات. تملك خيار "Trend Flags" و "Results"، وبرمجنا أيقونة وحالة الـ Result لتتحول للون الأخضر عند `Pass/Stable` كشارة نصية `Badge`.
* `app/Filament/Resources/PackagingResource.php` و ملفاتها
  * **الهدف:** بيانات التغليف وإدارة خصائص منع الرطوبة WVTR.
* `app/Filament/Pages/DoeWorkspace.php` و `doe-workspace.blade.php`
  * **الهدف:** صفحة Custom مخصصة للمعامل الإحصائية، بُنيت بشكل مستقل بعيداً عن الجداول لتكون منصة مستقبلية جاهزة لربط خوارزميات بايثون (DOE & Optimization Matrices). 
* **ملاحظة الدعم للأصدارات (Filament Schema Patch):**
  * جميع الواجهات الجديدة تم استخدام التركيبة الحديثة فيها `public static function form(Schema $schema): Schema` باستخدام `components()` لتتوافق تماماً مع بنية النظام الحديث لديكم. 

---

**هذا المرجع يحتوي على الشيفرة الوراثية للنظام. بإمكانك الاعتماد عليه عند تسليم النظام لمطورين إضافيين لتوضيح مكان وزمان كل عملية.**
