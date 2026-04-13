import os, glob, re

migrations_dir = r"c:\Users\Dell\Desktop\EDOS\edocs\database\migrations"

schemas = {
    "projects": """$table->id();
            $table->string('project_code')->nullable();
            $table->string('project_name')->nullable();
            $table->unsignedBigInteger('api_id')->nullable();
            $table->string('dosage_form')->nullable();
            $table->string('development_stage')->nullable();
            $table->string('reference_product')->nullable();
            $table->string('target_market')->nullable();
            $table->string('project_status')->nullable();
            $table->string('owner')->nullable();
            $table->timestamps();""",
            
    "product_profiles": """$table->id();
            $table->unsignedBigInteger('project_id');
            $table->decimal('strength_mg', 10, 3)->nullable();
            $table->decimal('fill_weight_target_mg', 10, 3)->nullable();
            $table->decimal('target_effervescence_sec', 8, 2)->nullable();
            $table->decimal('target_pH', 5, 2)->nullable();
            $table->decimal('pH_low', 5, 2)->nullable();
            $table->decimal('pH_high', 5, 2)->nullable();
            $table->decimal('target_f2_min', 8, 2)->nullable();
            $table->decimal('max_moisture_pct', 5, 2)->nullable();
            $table->decimal('max_cu_rsd_pct', 5, 2)->nullable();
            $table->decimal('rh_limit_pct', 5, 2)->nullable();
            $table->timestamps();
            
            $table->foreign('project_id')->references('id')->on('projects')->onDelete('cascade');""",

    "excipients": """$table->id();
            $table->string('excipient_name');
            $table->string('category')->nullable();
            $table->decimal('mw', 10, 4)->nullable();
            $table->decimal('acid_equivalents', 8, 4)->nullable();
            $table->decimal('base_equivalents', 8, 4)->nullable();
            $table->string('pKa_or_buffer_role')->nullable();
            $table->decimal('typical_lod_pct', 5, 2)->nullable();
            $table->string('hygroscopicity_level')->nullable();
            $table->decimal('cost_per_mg', 15, 6)->nullable();
            $table->text('compatibility_flags')->nullable();
            $table->timestamps();""",
            
    "apis": """$table->id();
            $table->string('name');
            $table->string('description')->nullable();
            $table->timestamps();""",
            
    "formulas": """$table->id();
            $table->unsignedBigInteger('project_id');
            $table->string('formula_code');
            $table->string('formula_status')->nullable();
            $table->decimal('target_fill_weight_mg', 10, 3)->nullable();
            $table->decimal('actual_fill_weight_mg', 10, 3)->nullable();
            $table->decimal('predicted_eq_ratio', 8, 4)->nullable();
            $table->decimal('predicted_pH_raw', 5, 2)->nullable();
            $table->decimal('compliance_pH', 5, 2)->nullable();
            $table->decimal('predicted_co2_ml', 10, 3)->nullable();
            $table->decimal('predicted_cost_per_unit', 10, 4)->nullable();
            $table->string('approval_state')->nullable();
            $table->timestamps();
            
            $table->foreign('project_id')->references('id')->on('projects')->onDelete('cascade');""",
            
    "formula_components": """$table->id();
            $table->unsignedBigInteger('formula_id');
            $table->unsignedBigInteger('material_id')->nullable();
            $table->string('material_type')->nullable(); // Can be Excpients or Apis
            $table->string('role_in_formula')->nullable();
            $table->decimal('amount_mg', 10, 4)->nullable();
            $table->decimal('moles', 10, 6)->nullable();
            $table->decimal('acid_eq_contribution', 10, 6)->nullable();
            $table->decimal('base_eq_contribution', 10, 6)->nullable();
            $table->decimal('cost_contribution', 15, 6)->nullable();
            $table->boolean('is_critical_component')->default(false);
            $table->timestamps();
            
            $table->foreign('formula_id')->references('id')->on('formulas')->onDelete('cascade');""",
            
    "experiments": """$table->id();
            $table->unsignedBigInteger('project_id');
            $table->unsignedBigInteger('formula_id')->nullable();
            $table->string('experiment_type')->nullable();
            $table->string('experiment_code')->nullable();
            $table->decimal('batch_size', 10, 3)->nullable();
            $table->string('equipment_used')->nullable();
            $table->string('process_route')->nullable();
            $table->text('objective')->nullable();
            $table->string('run_status')->nullable();
            $table->timestamps();
            
            $table->foreign('project_id')->references('id')->on('projects')->onDelete('cascade');
            $table->foreign('formula_id')->references('id')->on('formulas')->onDelete('set null');""",
            
    "experiment_results": """$table->id();
            $table->unsignedBigInteger('experiment_id');
            $table->decimal('effervescence_sec', 8, 2)->nullable();
            $table->decimal('f2_worst', 8, 2)->nullable();
            $table->decimal('moisture_pct', 5, 2)->nullable();
            $table->decimal('cu_rsd_pct', 5, 2)->nullable();
            $table->decimal('measured_pH', 5, 2)->nullable();
            $table->integer('taste_score')->nullable();
            $table->string('appearance_result')->nullable();
            $table->string('pass_fail')->nullable();
            $table->timestamps();
            
            $table->foreign('experiment_id')->references('id')->on('experiments')->onDelete('cascade');""",
            
    "risk_records": """$table->id();
            $table->unsignedBigInteger('project_id');
            $table->string('failure_mode');
            $table->integer('severity')->nullable();
            $table->integer('occurrence')->nullable();
            $table->integer('detectability')->nullable();
            $table->integer('rpn')->nullable();
            $table->text('mitigation')->nullable();
            $table->string('gate_state')->nullable();
            $table->timestamps();
            
            $table->foreign('project_id')->references('id')->on('projects')->onDelete('cascade');""",
            
    "stability_records": """$table->id();
            $table->unsignedBigInteger('project_id');
            $table->unsignedBigInteger('formula_id')->nullable();
            $table->string('condition')->nullable();
            $table->string('timepoint')->nullable();
            $table->text('results')->nullable();
            $table->string('trend_flags')->nullable();
            $table->timestamps();
            
            $table->foreign('project_id')->references('id')->on('projects')->onDelete('cascade');
            $table->foreign('formula_id')->references('id')->on('formulas')->onDelete('set null');""",
            
    "decision_records": """$table->id();
            $table->unsignedBigInteger('project_id');
            $table->string('decision_type');
            $table->text('rationale')->nullable();
            $table->string('linked_evidence')->nullable();
            $table->timestamps();
            
            $table->foreign('project_id')->references('id')->on('projects')->onDelete('cascade');""",
}

for file_path in glob.glob(os.path.join(migrations_dir, "*_create_*_table.php")):
    filename = os.path.basename(file_path)
    match = re.search(r'create_(.+?)_table', filename)
    if match:
        table_name = match.group(1)
        if table_name in schemas:
            with open(file_path, 'r', encoding='utf-8') as f:
                content = f.read()

            new_body = schemas[table_name]
            
            # Find the Schema::create block
            content = re.sub(r'(\$table->id\(\);.*?\$table->timestamps\(\);)', new_body.replace('\\', '\\\\'), content, flags=re.DOTALL)
            
            with open(file_path, 'w', encoding='utf-8') as f:
                f.write(content)
            print(f"Updated {table_name}")
