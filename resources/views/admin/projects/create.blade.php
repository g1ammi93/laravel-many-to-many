@extends('layouts.app')

@section('title', ' Crea Progetto')

@section('content')
    <header>
        <h1>Nuovo Progetto</h1>
    </header>

    @include('includes.projects.form')


@endsection

@section('scripts')
    @vite('resources/js/image_preview.js')

@endsection
