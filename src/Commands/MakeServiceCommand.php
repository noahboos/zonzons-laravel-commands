<?php

namespace NoahBoos\LaravelCommands\Commands;

use Illuminate\Console\Command;
use Illuminate\Filesystem\Filesystem;
use Illuminate\Support\Str;
use NoahBoos\LaravelCommands\Support\PackagePath;

class MakeServiceCommand extends Command {
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'make:service {name}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Create a new service class.';

    public function __construct(
        protected Filesystem $files
    ) {
        parent::__construct();
    }

    /**
     * Execute the console command.
     */
    public function handle(): int {
        $this->createBaseService();

        return $this->createRequestedService();
    }

    public function createBaseService(): void {
        $path = app_path('Services/Service.php');

        if (file_exists($path)) {
            return;
        }

        $this->files->ensureDirectoryExists(app_path('Services'));

        $stub = $this->files->get(PackagePath::stubs() . '/base-service.stub');

        $this->files->put($path, $stub);
    }

    public function createRequestedService(): int {
        $name = $this->argument('name');
        $className = Str::studly($name) . 'Service';

        $path = app_path('Services/' . $className . '.php');

        if (file_exists($path)) {
            $this->error('Service already exists!');
            return self::FAILURE;
        }

        $this->files->ensureDirectoryExists(app_path('Services'));

        $stub = $this->files->get(PackagePath::stubs() . '/requested-service.stub');
        $stub = str_replace('{{ $className }}', $className, $stub);

        $this->files->put($path, $stub);

        $this->info('Service created successfully!');
        return self::SUCCESS;
    }
}
