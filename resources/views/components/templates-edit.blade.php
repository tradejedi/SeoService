{{-- resources/views/templates-edit.blade.php --}}
<form action="{{ route('seo.templates.update') }}" method="POST">
    @csrf
    {{-- Можно отдельными полями для каждой модели и ключа --}}
    @foreach($allTemplates as $template)
        <div>
            <label>
                {{ $template->model_type ?? 'Global' }} - {{ $template->key }}
                <input type="text" name="templates[{{ $template->id }}]" value="{{ $template->template }}">
            </label>
        </div>
    @endforeach

    <button type="submit">Сохранить</button>
</form>
