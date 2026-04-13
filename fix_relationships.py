import os
import re

base_dir = r"c:\Users\Dell\Desktop\EDOS\edocs\app\Filament\Resources"

replacements_form = {
    "api_id": "Select::make('api_id')->relationship('api', 'name')",
    "project_id": "Select::make('project_id')->relationship('project', 'project_name')",
    "formula_id": "Select::make('formula_id')->relationship('formula', 'formula_code')",
    "experiment_id": "Select::make('experiment_id')->relationship('experiment', 'experiment_code')"
}

replacements_table = {
    "api_id": "TextColumn::make('api.name')->sortable()",
    "project_id": "TextColumn::make('project.project_name')->sortable()",
    "formula_id": "TextColumn::make('formula.formula_code')->sortable()",
    "experiment_id": "TextColumn::make('experiment.experiment_code')->sortable()"
}

for root, _, files in os.walk(base_dir):
    for filename in files:
        if filename.endswith("Form.php"):
            path = os.path.join(root, filename)
            with open(path, "r", encoding="utf-8") as f:
                content = f.read()

            if "use Filament\\Forms\\Components\\Select;" not in content:
                content = content.replace("use Filament\\Forms\\Components\\TextInput;", "use Filament\\Forms\\Components\\TextInput;\nuse Filament\\Forms\\Components\\Select;")
            
            for key, rep in replacements_form.items():
                pattern = r"TextInput::make\('" + key + r"'\)[\s\r\n\t]*->numeric\(\)[\s\r\n\t]*(->default\(null\),)?"
                content = re.sub(pattern, rep + ",", content)
                # handle if missing numeric
                pattern2 = r"TextInput::make\('" + key + r"'\)[\s\r\n\t]*(->default\(null\),)?"
                content = re.sub(pattern2, rep + ",", content)

            with open(path, "w", encoding="utf-8") as f:
                f.write(content)
            print(f"Updated {path}")
            
        elif filename.endswith("Table.php"):
            path = os.path.join(root, filename)
            with open(path, "r", encoding="utf-8") as f:
                content = f.read()

            for key, rep in replacements_table.items():
                pattern = r"TextColumn::make\('" + key + r"'\)[\s\r\n\t]*->numeric\(\)[\s\r\n\t]*(->sortable\(\),)?"
                content = re.sub(pattern, rep + ",", content)
                # missing numeric
                pattern2 = r"TextColumn::make\('" + key + r"'\)[\s\r\n\t]*(->sortable\(\),)?"
                content = re.sub(pattern2, rep + ",", content)

            with open(path, "w", encoding="utf-8") as f:
                f.write(content)
            print(f"Updated {path}")
