<?php

namespace CoolmacJedi\SeoService\Services;

use CoolmacJedi\SeoService\Models\SeoTag;
use CoolmacJedi\SeoService\Models\SeoTemplate;
use Illuminate\Database\Eloquent\Model;

class SeoManager
{
    /**
     * Получить массив SEO-тегов для заданной модели.
     *
     * @param  Model  $model
     * @return array  [ 'title' => '...', 'description' => '...' ]
     */
    public function getSeoForModel(Model $model): array
    {
        $modelType = get_class($model);

        // Собираем все необходимые ключи из конфига
        $keys = config('seo.keys', []);

        $result = [];

        foreach ($keys as $key) {
            // 1. Ищем конкретный SeoTag для записи
            $tag = SeoTag::where('model_type', $modelType)
                ->where('model_id', $model->getKey())
                ->where('key', $key)
                ->first();

            if ($tag) {
                $result[$key] = $tag->value;
                continue;
            }

            // 2. Ищем модельный SeoTemplate
            $template = SeoTemplate::where('model_type', $modelType)
                ->where('key', $key)
                ->first();

            if ($template) {
                $result[$key] = $this->replacePlaceholders($template->template, $model);
                continue;
            }

            // 3. Ищем глобальный SeoTemplate
            $globalTemplate = SeoTemplate::whereNull('model_type')
                ->where('key', $key)
                ->first();

            if ($globalTemplate) {
                $result[$key] = $this->replacePlaceholders($globalTemplate->template, $model);
                continue;
            }

            // 4. Если ничего не найдено, берём из config('seo.global_defaults')
            $defaultTemplate = config("seo.global_defaults.$key");
            if ($defaultTemplate) {
                $result[$key] = $this->replacePlaceholders($defaultTemplate, $model);
            } else {
                // fallback - пустая строка или null
                $result[$key] = '';
            }
        }

        return $result;
    }

    /**
     * Заменяем плейсхолдеры вида :field: на соответствующие поля модели.
     *
     * @param  string  $template
     * @param  Model   $model
     * @return string
     */
    protected function replacePlaceholders(string $template, Model $model): string
    {
        // Ищем все :field: и пытаемся подставить $model->field
        // Для простоты берём только простые поля. Можно доработать.
        return preg_replace_callback('/:([\w_]+):/', function ($matches) use ($model) {
            $field = $matches[1];
            return $model->{$field} ?? '';
        }, $template);
    }

    /**
     * Сохранить (переопределить) конкретный SEO-тег для записи.
     *
     * @param  Model  $model
     * @param  string $key
     * @param  string $value
     * @return SeoTag
     */
    public function setSeoTag(Model $model, string $key, string $value): SeoTag
    {
        $modelType = get_class($model);

        return SeoTag::updateOrCreate(
            [
                'model_type' => $modelType,
                'model_id'   => $model->getKey(),
                'key'        => $key,
            ],
            [
                'value' => $value,
            ]
        );
    }

    /**
     * Сохранить шаблон для модели (или глобальный, если $modelType === null).
     *
     * @param  string|null  $modelType
     * @param  string       $key
     * @param  string       $template
     * @return SeoTemplate
     */
    public function setSeoTemplate(?string $modelType, string $key, string $template): SeoTemplate
    {
        return SeoTemplate::updateOrCreate(
            [
                'model_type' => $modelType,
                'key'        => $key,
            ],
            [
                'template' => $template,
            ]
        );
    }
}
