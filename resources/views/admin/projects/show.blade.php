@extends('layouts.app')

@section('title', 'Projects')

@section('content')

    <header>
        <h1 class="mt-4 mb-1"> {{ $project->title }}</h1>
        <p>Categoria: @if ($project->category)
                <span class="badge rounded-pill" style="background-color: {{ $project->category->color }}">
                    {{ $project->category->label }}
                </span>
            @else
                Nessuna
            @endif
        </p>
    </header>



    <div class="clearfix">
        @if ($project->image)
            <img src="{{ $project->printImage() }}" alt="{{ $project->title }}" class="me-2 float-start">
        @endif
        <p>{{ $project->description }}</p>
        <div>
            <strong>Creato il:</strong> {{ $project->getFormattedDate('created_at') }}
            <strong>Ultima modifica:</strong> {{ $project->getFormattedDate('updated_at') }}
        </div>
    </div>


    <footer class="d-flex justify-content-between align-items-center my-3">
        <a href="{{ route('admin.projects.index') }}" class="btn btn-secondary">
            <i class="fas fa-arrow-left me-2"></i>Torna Indietro
        </a>

        <div class="d-flex justify-content-between gap-2">
            <a href="{{ route('admin.projects.edit', $project) }}" class="btn btn-warning">
                <i class="fas fa-pencil me-2"></i>Modifica</a>

            <form action="{{ route('admin.projects.destroy', $project->id) }}" method="POST" class="delete-form">
                @csrf
                @method('DELETE')
                <button type="submit" class="btn btn-danger"><i class="fas fa-trash-can me-2"></i>Elimina </button>
            </form>
        </div>
    </footer>
@endsection

@section('scripts')
    @vite('resources/js/delete_confirmation.js')
@endsection
