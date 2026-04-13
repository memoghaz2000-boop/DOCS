<?php

$dir = __DIR__ . '/app/Models';

$models = [
    'Project' => <<<EOD
<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Project extends Model
{
    use HasFactory;

    protected \$fillable = [
        'project_code', 'project_name', 'api_id', 'dosage_form', 'development_stage',
        'reference_product', 'target_market', 'project_status', 'owner'
    ];

    public function api() {
        return \$this->belongsTo(Api::class);
    }

    public function productProfile() {
        return \$this->hasOne(ProductProfile::class);
    }

    public function formulas() {
        return \$this->hasMany(Formula::class);
    }

    public function experiments() {
        return \$this->hasMany(Experiment::class);
    }

    public function riskRecords() {
        return \$this->hasMany(RiskRecord::class);
    }

    public function stabilityRecords() {
        return \$this->hasMany(StabilityRecord::class);
    }

    public function decisionRecords() {
        return \$this->hasMany(DecisionRecord::class);
    }
}
EOD,

    'ProductProfile' => <<<EOD
<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProductProfile extends Model
{
    use HasFactory;

    protected \$fillable = [
        'project_id', 'strength_mg', 'fill_weight_target_mg', 'target_effervescence_sec',
        'target_pH', 'pH_low', 'pH_high', 'target_f2_min', 'max_moisture_pct',
        'max_cu_rsd_pct', 'rh_limit_pct'
    ];

    public function project() {
        return \$this->belongsTo(Project::class);
    }
}
EOD,

    'Excipient' => <<<EOD
<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Excipient extends Model
{
    use HasFactory;

    protected \$fillable = [
        'excipient_name', 'category', 'mw', 'acid_equivalents', 'base_equivalents',
        'pKa_or_buffer_role', 'typical_lod_pct', 'hygroscopicity_level',
        'cost_per_mg', 'compatibility_flags'
    ];
}
EOD,

    'Api' => <<<EOD
<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Api extends Model
{
    use HasFactory;

    protected \$fillable = [
        'name', 'description'
    ];
}
EOD,

    'Formula' => <<<EOD
<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Formula extends Model
{
    use HasFactory;

    protected \$fillable = [
        'project_id', 'formula_code', 'formula_status', 'target_fill_weight_mg',
        'actual_fill_weight_mg', 'predicted_eq_ratio', 'predicted_pH_raw',
        'compliance_pH', 'predicted_co2_ml', 'predicted_cost_per_unit', 'approval_state'
    ];

    public function project() {
        return \$this->belongsTo(Project::class);
    }

    public function components() {
        return \$this->hasMany(FormulaComponent::class);
    }
}
EOD,

    'FormulaComponent' => <<<EOD
<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class FormulaComponent extends Model
{
    use HasFactory;

    protected \$fillable = [
        'formula_id', 'material_id', 'material_type', 'role_in_formula',
        'amount_mg', 'moles', 'acid_eq_contribution', 'base_eq_contribution',
        'cost_contribution', 'is_critical_component'
    ];

    public function formula() {
        return \$this->belongsTo(Formula::class);
    }
}
EOD,

    'Experiment' => <<<EOD
<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Experiment extends Model
{
    use HasFactory;

    protected \$fillable = [
        'project_id', 'formula_id', 'experiment_type', 'experiment_code',
        'batch_size', 'equipment_used', 'process_route', 'objective', 'run_status'
    ];

    public function project() {
        return \$this->belongsTo(Project::class);
    }

    public function formula() {
        return \$this->belongsTo(Formula::class);
    }

    public function results() {
        return \$this->hasMany(ExperimentResult::class);
    }
}
EOD,

    'ExperimentResult' => <<<EOD
<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ExperimentResult extends Model
{
    use HasFactory;

    protected \$fillable = [
        'experiment_id', 'effervescence_sec', 'f2_worst', 'moisture_pct',
        'cu_rsd_pct', 'measured_pH', 'taste_score', 'appearance_result', 'pass_fail'
    ];

    public function experiment() {
        return \$this->belongsTo(Experiment::class);
    }
}
EOD,

    'RiskRecord' => <<<EOD
<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RiskRecord extends Model
{
    use HasFactory;

    protected \$fillable = [
        'project_id', 'failure_mode', 'severity', 'occurrence', 'detectability',
        'rpn', 'mitigation', 'gate_state'
    ];

    public function project() {
        return \$this->belongsTo(Project::class);
    }
}
EOD,

    'StabilityRecord' => <<<EOD
<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class StabilityRecord extends Model
{
    use HasFactory;

    protected \$fillable = [
        'project_id', 'formula_id', 'condition', 'timepoint', 'results', 'trend_flags'
    ];

    public function project() {
        return \$this->belongsTo(Project::class);
    }

    public function formula() {
        return \$this->belongsTo(Formula::class);
    }
}
EOD,

    'DecisionRecord' => <<<EOD
<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DecisionRecord extends Model
{
    use HasFactory;

    protected \$fillable = [
        'project_id', 'decision_type', 'rationale', 'linked_evidence'
    ];

    public function project() {
        return \$this->belongsTo(Project::class);
    }
}
EOD
];

foreach (\$models as \$name => \$content) {
    file_put_contents(\$dir . '/' . \$name . '.php', \$content);
    echo "Updated {\$name}\\n";
}
