@extends('home')

@section('title', 'Documentación - API')

@section('css-import')
@parent
@vite(['resources/scss/app.scss', 'resources/css/app.css'])
@endsection

@section('content')
<main id="app" class="d-flex flex-nowrap">

</main>
<div id="modals"></div>
@endsection

@section('scripts')
@parent
@vite(['resources/js/doc/api/api.js'])
@endsection
