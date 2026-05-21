<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Str;

class MakeRepository extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'make:repository {model : Base name of the model, for example User or Cita}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Scaffold repository and interface files for a model and ensure the backend structure exists';

    /**
     * Execute the console command.
     */
    public function handle(): int
    {
        $modelName = Str::studly($this->argument('model'));

        $this->ensureBackendStructure();

        $createdFiles = $this->createRepositoryFiles($modelName);

        if ($createdFiles === []) {
            $this->warn('No files were created because they already exist.');

            return self::SUCCESS;
        }

        $this->info('Files created successfully:');

        foreach ($createdFiles as $createdFile) {
            $this->line('- '.$createdFile);
        }

        return self::SUCCESS;
    }

    private function ensureBackendStructure(): void
    {
        foreach ([
            app_path('Repositories'),
            app_path('Repositories/Contracts'),
            app_path('Http/Controllers/Api'),
            app_path('Http/Requests'),
            app_path('Http/Resources'),
            app_path('Services'),
            app_path('Actions'),
        ] as $directory) {
            File::ensureDirectoryExists($directory);
        }
    }

    private function createRepositoryFiles(string $modelName): array
    {
        $filesCreated = [];

        $repositoryClass = $modelName.'Repository';
        $interfaceClass = $repositoryClass.'Interface';

        $repositoryPath = app_path('Repositories/'.$repositoryClass.'.php');
        $interfacePath = app_path('Repositories/Contracts/'.$interfaceClass.'.php');

        if ($this->createFileFromStub($repositoryPath, base_path('stubs/repository.stub'), [
            'class' => $repositoryClass,
            'namespace' => 'App\\Repositories',
            'interface' => $interfaceClass,
            'contract_namespace' => 'App\\Repositories\\Contracts\\'.$interfaceClass,
        ])) {
            $filesCreated[] = 'app/Repositories/'.$repositoryClass.'.php';
        }

        if ($this->createFileFromStub($interfacePath, base_path('stubs/repository-interface.stub'), [
            'interface' => $interfaceClass,
            'namespace' => 'App\\Repositories\\Contracts',
        ])) {
            $filesCreated[] = 'app/Repositories/Contracts/'.$interfaceClass.'.php';
        }

        return $filesCreated;
    }

    private function createFileFromStub(string $targetPath, string $stubPath, array $replacements): bool
    {
        if (File::exists($targetPath)) {
            $this->warn(basename($targetPath).' already exists');

            return false;
        }

        $stubContent = File::get($stubPath);

        foreach ($replacements as $placeholder => $value) {
            $stubContent = str_replace('{{ '.$placeholder.' }}', $value, $stubContent);
        }

        File::put($targetPath, $stubContent);

        return true;
    }
}
