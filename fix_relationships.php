<?php

$base_dir = 'C:\Users\Dell\Desktop\EDOS\edocs\app\Filament\Resources';

$replacements_form = [
    "api_id" => "Select::make('api_id')->relationship('api', 'name')",
    "project_id" => "Select::make('project_id')->relationship('project', 'project_name')",
    "formula_id" => "Select::make('formula_id')->relationship('formula', 'formula_code')",
    "experiment_id" => "Select::make('experiment_id')->relationship('experiment', 'experiment_code')"
];

$replacements_table = [
    "api_id" => "TextColumn::make('api.name')->sortable()",
    "project_id" => "TextColumn::make('project.project_name')->sortable()",
    "formula_id" => "TextColumn::make('formula.formula_code')->sortable()",
    "experiment_id" => "TextColumn::make('experiment.experiment_code')->sortable()"
];

$iterator = new RecursiveIteratorIterator(new RecursiveDirectoryIterator($base_dir));

foreach ($iterator as $file) {
    if ($file->isFile()) {
        $filename = $file->getFilename();
        $path = $file->getPathname();
        
        if (str_ends_with($filename, 'Form.php')) {
            $content = file_get_contents($path);
            
            if (strpos($content, 'use Filament\Forms\Components\Select;') === false) {
                $content = str_replace('use Filament\Forms\Components\TextInput;', "use Filament\Forms\Components\TextInput;\nuse Filament\Forms\Components\Select;", $content);
            }
            
            foreach ($replacements_form as $key => $rep) {
                $content = preg_replace("/TextInput::make\('{$key}'\)[\s\r\n\t]*->numeric\(\)[\s\r\n\t]*(->default\(null\),)?/", $rep . ',', $content);
                $content = preg_replace("/TextInput::make\('{$key}'\)[\s\r\n\t]*(->default\(null\),)?/", $rep . ',', $content);
            }
            
            file_put_contents($path, $content);
            echo "Updated {$path}\n";
        } elseif (str_ends_with($filename, 'Table.php')) {
            $content = file_get_contents($path);
            
            foreach ($replacements_table as $key => $rep) {
                $content = preg_replace("/TextColumn::make\('{$key}'\)[\s\r\n\t]*->numeric\(\)[\s\r\n\t]*(->sortable\(\),)?/", $rep . ',', $content);
                $content = preg_replace("/TextColumn::make\('{$key}'\)[\s\r\n\t]*(->sortable\(\),)?/", $rep . ',', $content);
            }
            
            file_put_contents($path, $content);
            echo "Updated {$path}\n";
        }
    }
}
