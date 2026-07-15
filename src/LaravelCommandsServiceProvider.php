<?php

namespace NoahBoos\LaravelCommands;

use Illuminate\Support\ServiceProvider;
use Noahboos\LaravelCommands\Commands\MakeHelperCommand;
use Noahboos\LaravelCommands\Commands\MakeServiceCommand;

class LaravelCommandsServiceProvider extends ServiceProvider {
    /**
     * Register services.
     */
    public function register(): void {
        //
    }

    /**
     * Bootstrap services.
     */
    public function boot(): void {
        $this->commands([
            MakeHelperCommand::class,
            MakeServiceCommand::class
        ]);
    }
}
