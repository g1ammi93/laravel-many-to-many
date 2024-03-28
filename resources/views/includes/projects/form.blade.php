@if ($project->exists)
    <form action="{{ route('admin.projects.update', $project) }}" method="POST" enctype="multipart/form-data">
        @method('PUT')
    @else
        <form action="{{ route('admin.projects.store', $project) }}" method="POST" enctype="multipart/form-data">
@endif
@csrf
<div class="row">
    <div class="col-12">
        <div class="mb-3">
            <label for="title" class="form-label">Titolo</label>
            <input type="text"
                class="form-control @error('title') is-invalid @elseif(old('title', '')) is-valid @enderror"
                id="title" name="title" placeholder="Titolo..." value="{{ old('title', $project->title) }}">
            @error('title')
                <div class="invalid-feedback">
                    {{ $message }}
                </div>
            @else
                <div class="form-text">
                    Inserisci il titolo del Progetto

                </div>
            @enderror
        </div>
    </div>
    <div class="col-12">
        <div class="mb-3">
            <label for="description" class="form-label">Descrizione del Progetto</label>
            <textarea class="form-control @error('description') is-invalid @elseif(old('description', '')) is-valid @enderror"
                id="description" name="description" rows="10">
                    {{ old('desription', $project->description) }}
                </textarea>
            @error('description')
                <div class="invalid-feedback">
                    {{ $message }}
                </div>
            @else
                <div class="form-text">
                    Inserisci la descrizione del Progetto

                </div>
            @enderror
        </div>
    </div>
    <div class="col-6">
        <div class="mb-3">
            <label for="category_id" class="form-label">Seleziona Categoria</label>
            <select name="category_id" id="category_id"
                class="form-select @error('category_id') is-invalid @elseif(old('category_id', '')) is-valid @enderror">
                <option value="">Nessuna</option>
                @foreach ($categories as $category)
                    <option value="{{ $category->id }}" @if (old('category_id', $project->$category?->id) == $category->id) selected @endif>
                        {{ $category->label }}</option>
                @endforeach
            </select>
            @error('category_id')
                <div class="invalid-feedback">
                    {{ $message }}
                </div>
            @enderror
        </div>
    </div>
    <div class="col-5">
        <div class="mb-3">
            <label for="image" class="form-label">Image</label>
            <input type="file"
                class="form-control @error('image') is-invalid @elseif(old('image', '')) is-valid @enderror"
                id="image" name="image" placeholder="https://..." value="{{ old('image', $project->image) }}">
        </div>
        @error('image')
            <div class="invalid-feedback"></div>
            {{ $message }}
        @else
            <div class="form-text">
                Carica un file Immagine

            </div>
        @enderror
    </div>
    <div class="col-1">
        <div class="mb-3">
            <img src="{{ old('image', $project->image) ? asset('storage/' . old('image', $project->image)) : 'https://marcolanci.it/boolean/assets/placeholder.png' }}"
                class="img-fluid" alt="Immagine post" id="preview">
        </div>
    </div>
</div>

<div class="d-flex justify-content-between align-items-center">
    <a href="{{ route('admin.projects.index') }}" class="btn btn-primary">Torna alla lista</a>
    <div class="d-flex align-items-center gap-2">
        <button type="reset" class="btn btn-secondary"><i class="fas fa-eraser me-2"></i>Svuota i
            campi</button>
        <button type="submit" class="btn btn-success"><i class="fas fa-floppy-disk me-2"></i>Salva</button>
    </div>
</div>
</form>
