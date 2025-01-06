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
        // 1. Сливаем конфиг
        $this->mergeConfigFrom(__DIR__ . '/../config/seo.php', 'seo');

        // 2. Регистрируем сервис (Resolver) в контейнере
        $this->app->singleton(SeoResolverContract::class, function ($app) {
            return new SeoResolver($app->make(SeoManager::class));
        });
    }

    public function boot()
    {
        // 1. Публикация конфигурации
        $this->publishes([
            __DIR__ . '/../config/seo.php' => config_path('seo.php'),
        ], 'seo-config');

        // 2. Публикация (или автозагрузка) миграций
        $this->loadMigrationsFrom(__DIR__ . '/../database/migrations');

        // 3. Публикация (или автозагрузка) вьюх
        $this->publishes([
            __DIR__ . '/../resources/views' => resource_path('views/vendor/seo-service'),
        ], 'seo-views');

        // 4. Загрузка вьюх с нужным namespace
        $this->loadViewsFrom(__DIR__ . '/../resources/views', 'seo-service');

        // 5. Регистрируем Blade-компоненты, если нужно
        Blade::componentNamespace('TradeJedi\SeoService\View\Components', 'seo-service');

        // 6. Загружаем роуты
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
