<?php

namespace Modules\DigitalSignatureGenerateQr\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Database\Eloquent\Factory;

class DigitalSignatureGenerateQrServiceProvider extends ServiceProvider
{
    /**
     * Boot the application events.
     *
     * @return void
     */
    public function boot()
    {
        $this->registerTranslations();
        $this->registerConfig();
        $this->registerViews();
        $this->registerFactories();
        $this->loadMigrationsFrom(module_path('DigitalSignatureGenerateQr', 'Database/Migrations'));
    }

    /**
     * Register the service provider.
     *
     * @return void
     */
    public function register()
    {
        $this->app->register(RouteServiceProvider::class);
    }

    /**
     * Register config.
     *
     * @return void
     */
    protected function registerConfig()
    {
        $this->publishes([
            module_path('DigitalSignatureGenerateQr', 'Config/config.php') => config_path('digitalsignaturegenerateqr.php'),
        ], 'config');
        $this->mergeConfigFrom(
            module_path('DigitalSignatureGenerateQr', 'Config/config.php'), 'digitalsignaturegenerateqr'
        );
    }

    /**
     * Register views.
     *
     * @return void
     */
    public function registerViews()
    {
        $viewPath = resource_path('views/modules/digitalsignaturegenerateqr');

        $sourcePath = module_path('DigitalSignatureGenerateQr', 'Resources/views');

        $this->publishes([
            $sourcePath => $viewPath
        ],'views');

        $this->loadViewsFrom(array_merge(array_map(function ($path) {
            return $path . '/modules/digitalsignaturegenerateqr';
        }, \Config::get('view.paths')), [$sourcePath]), 'digitalsignaturegenerateqr');
    }

    /**
     * Register translations.
     *
     * @return void
     */
    public function registerTranslations()
    {
        $langPath = resource_path('lang/modules/digitalsignaturegenerateqr');

        if (is_dir($langPath)) {
            $this->loadTranslationsFrom($langPath, 'digitalsignaturegenerateqr');
        } else {
            $this->loadTranslationsFrom(module_path('DigitalSignatureGenerateQr', 'Resources/lang'), 'digitalsignaturegenerateqr');
        }
    }

    /**
     * Register an additional directory of factories.
     *
     * @return void
     */
    public function registerFactories()
    {
        if (! app()->environment('production') && $this->app->runningInConsole()) {
            app(Factory::class)->load(module_path('DigitalSignatureGenerateQr', 'Database/factories'));
        }
    }

    /**
     * Get the services provided by the provider.
     *
     * @return array
     */
    public function provides()
    {
        return [];
    }
}
