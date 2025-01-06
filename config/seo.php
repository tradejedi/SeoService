<?php

return [
    /*
     * Список ключей (имён) SEO-тегов, которые мы собираемся поддерживать.
     * Можно выводить и OG-теги, и любые другие.
     */
    'keys' => [
        'title',
        'description',
        'keywords',
        'og:title',
        'og:description',
        // и т.д.
    ],

    /*
     * Глобальные шаблоны по умолчанию для тегов.
     * Используйте :attribute: для подстановки значений модели.
     * К примеру, :name: заменится на $model->name.
     */
    'global_defaults' => [
        'title' => 'Мой сайт - :name:',
        'description' => 'Описание всего сайта',
        'og:title' => 'Социальный заголовок - :name:',
        // ...
    ],

    /*
     * Маппинг (список) моделей, которые используем в SEO
     * Можно здесь указать namespace и ключ для модели.
     */
    'models' => [
        'post' => \App\Models\Post::class,
        'category' => \App\Models\Category::class,
        // ...
    ],
];
