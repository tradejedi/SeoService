<?php


namespace TradeJedi\SeoService\Contracts;

use Illuminate\Database\Eloquent\Model;
use TradeJedi\SeoService\Models\SeoTag;
use TradeJedi\SeoService\Models\SeoTemplate;

interface SeoResolverContract
{
    /**
     * Получить массив SEO-тегов для заданной модели.
     *
     * Пример возвращаемого массива:
     * [
     *   'title' => '...',
     *   'description' => '...',
     *   ...
     * ]
     *
     * @param Model $model
     * @return array
     */
    public function getSeoForModel(Model $model): array;

    /**
     * Переопределить (сохранить) конкретный SEO-тег для записи модели.
     *
     * @param Model $model
     * @param string $key
     * @param string $value
     * @return SeoTag
     */
    public function setSeoTag(Model $model, string $key, string $value): SeoTag;

    /**
     * Сохранить шаблон (template) для модели (или глобальный, если $modelType === null).
     *
     * @param string|null $modelType (FQCN модели или null для глобального)
     * @param string $key
     * @param string $template
     * @return SeoTemplate
     */
    public function setSeoTemplate(?string $modelType, string $key, string $template): SeoTemplate;
}
