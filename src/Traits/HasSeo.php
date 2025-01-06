<?php

namespace TradeJedi\SeoService\Traits;

use TradeJedi\SeoService\Services\SeoManager;
use Illuminate\Support\Facades\App;

trait HasSeo
{
    /**
     * Вернуть массив SEO-тегов для текущей модели.
     *
     * @return array
     */
    public function getSeoAttributes(): array
    {
        /** @var SeoManager $seoManager */
        $seoManager = App::make(SeoManager::class);
        return $seoManager->getSeoForModel($this);
    }

    /**
     * Переопределить конкретный SEO-тег для этой модели.
     *
     * @param  string  $key
     * @param  string  $value
     * @return void
     */
    public function setSeoTag(string $key, string $value): void
    {
        /** @var SeoManager $seoManager */
        $seoManager = App::make(SeoManager::class);
        $seoManager->setSeoTag($this, $key, $value);
    }
}
