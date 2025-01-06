<?php


namespace CoolmacJedi\SeoService;

use Illuminate\Database\Eloquent\Model;
use CoolmacJedi\SeoService\Contracts\SeoResolverContract;
use CoolmacJedi\SeoService\Models\SeoTag;
use CoolmacJedi\SeoService\Models\SeoTemplate;
use CoolmacJedi\SeoService\Services\SeoManager;

class SeoResolver implements SeoResolverContract
{
    /**
     * @var SeoManager
     */
    protected SeoManager $seoManager;

    /**
     * Внедряем SeoManager через конструктор.
     *
     * @param SeoManager $seoManager
     */
    public function __construct(SeoManager $seoManager)
    {
        $this->seoManager = $seoManager;
    }

    /**
     * Получить массив SEO-тегов (title, description и т.д.) для конкретной модели.
     */
    public function getSeoForModel(Model $model): array
    {
        // Здесь можно добавить дополнительную логику, например кеширование.
        // Пока просто делегируем вызов в SeoManager.
        return $this->seoManager->getSeoForModel($model);
    }

    /**
     * Переопределить (сохранить) конкретный SEO-тег для записи модели.
     */
    public function setSeoTag(Model $model, string $key, string $value): SeoTag
    {
        // Если нужно, можно добавить валидацию $key/$value, очистку html, логирование и т.д.
        return $this->seoManager->setSeoTag($model, $key, $value);
    }

    /**
     * Сохранить шаблон (template) для модели (или глобальный, если $modelType === null).
     */
    public function setSeoTemplate(?string $modelType, string $key, string $template): SeoTemplate
    {
        // Можно логировать изменения или применять другие правила,
        // а затем вызвать метод SeoManager.
        return $this->seoManager->setSeoTemplate($modelType, $key, $template);
    }
}
