<?php

namespace Module\Base\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Foundation\Console\AboutCommand;
use Module\Base\Commands\CreateModule;
use Module\Base\Commands\ListModules;

class BaseServiceProvider extends ServiceProvider
{
    protected string $moduleName = 'base';
    /**
     * Register services.
     */
    public function register(): void
    {
        $this->mergeConfigFrom(
            __DIR__.'/../config/module.php', $this->moduleName
        );
    }

    /**
     * Bootstrap services.
     */
    public function boot(): void
    {
        //
        AboutCommand::add(\Illuminate\Support\Str::ucfirst($this->moduleName).' Module', fn () => self::module());
        $this->loadRoutesFrom(__DIR__.'/../routes/web.php');
        $this->loadMigrationsFrom(__DIR__.'/../database/migrations');
        $this->loadViewsFrom(__DIR__.'/../resources/views', $this->moduleName);
        $this->publishes([
            __DIR__.'/../resources/views' => resource_path('views/vendor/'.$this->moduleName),
        ]);

        if ($this->app->runningInConsole()) {
            $this->commands([
                ListModules::class,
                CreateModule::class,
            ]);
        }
    }

    public static function module()
    {
        return [
            'Version' => '1.0.0',
            'Lisence' => 'MIT',
            'Authors' =>'Angga Purnama <anggagewor@gmail.com>'
        ];
    }
}
