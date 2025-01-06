{{-- resources/views/edit.blade.php --}}
<form action="{{ route('seo.tags.update', ['model' => $modelType, 'id' => $modelId]) }}" method="POST">
    @csrf
    @method('PUT')

    @foreach ($seoKeys as $key)
        <div>
            <label for="seo_{{ $key }}">{{ $key }}</label>
            <input type="text" id="seo_{{ $key }}" name="seo[{{ $key }}]" value="{{ $seo[$key] ?? '' }}">
        </div>
    @endforeach

    <button type="submit">Сохранить</button>
</form>
