{{-- resources/views/meta.blade.php --}}
@if(!empty($seo['title']))
    <title>{{ $seo['title'] }}</title>
@endif

@if(!empty($seo['description']))
    <meta name="description" content="{{ $seo['description'] }}">
@endif

@if(!empty($seo['keywords']))
    <meta name="keywords" content="{{ $seo['keywords'] }}">
@endif

{{-- OG-теги и т.д. --}}

