<?php


namespace TradeJedi\SeoService\View\Components;

use Illuminate\View\Component;

class Meta extends Component
{
    /**
     * Массив SEO-тегов (title, description, keywords и т.д.).
     */
    public array $seo;

    /**
     * Конструктор компонента.
     * При вызове <x-seoservice::meta :seo="$seo" />
     * Laravel автоматически передаст проп $seo в этот конструктор.
     */
    public function __construct(array $seo = [])
    {
        $this->seo = $seo;
    }

    /**
     * Метод render() указывает, какой Blade-шаблон рендерить.
     */
    public function render()
    {
        // Предположим, что наш шаблон лежит в: resources/views/components/meta.blade.php
        // и публикуется/загружается с неймспейсом "laravel-seo"
        return view('seo-service::components.meta');
    }
}
