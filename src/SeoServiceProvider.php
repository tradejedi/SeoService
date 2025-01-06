<?php
namespace TradeJedi\SeoService;

use TradeJedi\SeoService\Contracts\SeoResolverContract;
use TradeJedi\SeoService\SeoResolver;
use TradeJedi\SeoService\Services\SeoManager;
use Illuminate\Support\Facades\Blade;
use Illuminate\Support\Facades\Route;
use TradeJedi\SeoService\Http\Controllers\SeoTagsController;
use TradeJedi\SeoService\Http\Controllers\SeoTemplatesController;
use Illuminate\Support\ServiceProvider;

class SeoServiceProvider extends ServiceProvider{
    public function register()
    {
        // Регистрируем конфиг
        $this->mergeConfigFrom(__DIR__ . '/../config/seo.php', 'seo');

        $this->app->singleton(SeoResolverContract::class, function ($app) {
            // Внутри резолвера автоматически внедрится SeoManager
            return new SeoResolver($app->make(SeoManager::class));
        });

        $this->loadRoutes();
        $this->loadViewsFrom(__DIR__ . '/../resources/views', 'laravel-seo');
    }

    public function boot()
    {
        // Публикация конфигурации
        $this->publishes([
            __DIR__ . '/../config/seo.php' => config_path('seo.php'),
        ], 'seo-config');

        // Публикация миграций
        $this->loadMigrationsFrom(__DIR__ . '/../database/migrations');

        // Публикация вьюх
        $this->publishes([
            __DIR__ . '/../resources/views' => resource_path('views/vendor/seo-service'),
        ], 'seo-views');

        // Регистрация наших роутов / вью
        // 1. Сообщаем, где искать файлы вьюшек (если ещё не делали)
        $this->loadViewsFrom(__DIR__ . '/../resources/views', 'seo-service');

        // 2. Регистрируем пространство имён Blade-компонентов
        //    Например, "seoservice" → \LaravelSeo\SeoService\View\Components
        Blade::componentNamespace('TradeJedi\SeoService\View\Components', 'seo-service');

        $this->loadRoutes();
    }

    protected function loadRoutes()
    {
        Route::group([
            'prefix' => 'admin/seo',
            'middleware' => ['web', 'auth'], // или другие middleware, какие нужны
        ], function () {
            // Редактирование конкретных SEO-тегов
            Route::get('tags/{model}/{id}/edit', [SeoTagsController::class, 'edit'])->name('seo.tags.edit');
            Route::put('tags/{model}/{id}', [SeoTagsController::class, 'update'])->name('seo.tags.update');

            // Редактирование шаблонов
            Route::get('templates', [SeoTemplatesController::class, 'index'])->name('seo.templates.index');
            Route::post('templates', [SeoTemplatesController::class, 'update'])->name('seo.templates.update');
        });
    }

}
