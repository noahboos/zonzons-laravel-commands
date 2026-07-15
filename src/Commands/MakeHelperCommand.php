<?php

namespace NoahBoos\LaravelCommands\Commands;

use Illuminate\Console\Command;
use Illuminate\Filesystem\Filesystem;
use Illuminate\Support\Str;
use NoahBoos\LaravelCommands\Support\PackagePath;

class MakeHelperCommand extends Command {
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'make:helper {name}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Create a new helper class.';

    public function __construct(
        protected Filesystem $files
    ) {
        parent::__construct();
    }

    /**
     * Execute the console command.
     */
    public function handle(): int {
        $this->createBaseHelper();

        return $this->createRequestedHelper();
    }

    public function createBaseHelper(): void {
        $path = app_path('Helpers/Helper.php');

        if (file_exists($path)) {
            return;
        }

        $this->files->ensureDirectoryExists(app_path('Helpers'));

        $stub = $this->files->get(PackagePath::stubs() . '/base-helper.stub');

        $this->files->put($path, $stub);
    }

    public function createRequestedHelper(): int {
        $name = $this->argument('name');
        $className = Str::studly($name) . 'Helper';

        $path = app_path('Helpers/' . $className . '.php');

        if (file_exists($path)) {
            $this->error('Helper already exists!');
            return self::FAILURE;
        }

        $this->files->ensureDirectoryExists(app_path('Helpers'));

        $stub = $this->files->get(PackagePath::stubs() . '/requested-helper.stub');
        $stub = str_replace('{{ $className }}', $className, $stub);

        $this->files->put($path, $stub);

        $this->info('Helper created successfully!');
        return self::SUCCESS;
    }
}
