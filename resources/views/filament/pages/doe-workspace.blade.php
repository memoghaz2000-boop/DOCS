<x-filament-panels::page>
    <div class="px-4 py-8 bg-white border border-gray-200 rounded-xl shadow-sm dark:bg-gray-900 dark:border-white/10">
        <div class="flex items-center space-x-4">
            <div class="p-3 bg-primary-500/10 text-primary-500 rounded-lg">
                <x-heroicon-o-beaker class="w-8 h-8" />
            </div>
            <div>
                <h2 class="text-xl font-bold tracking-tight">Design of Experiments (DOE) Workspace</h2>
                <p class="text-sm text-gray-500 dark:text-gray-400">Statistical matrices and optimization models for effervescent formulations.</p>
            </div>
        </div>
        
        <div class="mt-8 prose dark:prose-invert max-w-none">
            <p>Welcome to the central hub for running factorial and response surface designs.</p>
            <ul>
                <li><strong>Matrix Generator:</strong> Define factors (e.g. Acid/Base Ratio, Compression Force) to generate testing matrices.</li>
                <li><strong>Statistical Analysis:</strong> Integration with Python/R to compute ANOVA, P-Values, and effects.</li>
                <li><strong>Optimization:</strong> Contour plots to identify the ultimate design space for the target QTPP.</li>
            </ul>
        </div>
    </div>
</x-filament-panels::page>
