<?php

namespace App\Providers;

use Carbon\CarbonImmutable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Date;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\URL;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    #[\Override]
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        $this->configureComands();
        $this->configureModels();
        $this->configureUrl();
    }

    protected function configureComands(): void
    {
        // Prohibit destructive commands in production
        DB::prohibitDestructiveCommands(
            $this->app->isProduction()
        );
    }

    protected function configureModels(): void
    {
        // Use immutable dates
        Date::use(CarbonImmutable::class);

        // Enable strict mode for Eloquent models
        Model::shouldBeStrict();

        Model::unguard();

        // Prevent lazy loading
        Model::preventLazyLoading(
            ! $this->app->isProduction()
        );



        Date::use(CarbonImmutable::class);
    }

    protected function configureUrl(): void
    {
        URL::forceScheme('https');
    }


}
