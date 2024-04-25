@extends('home')

@section('title', 'Dashboard')

@section('css-import')
@parent
@vite(['resources/scss/app.scss', 'resources/css/app.css'])
@endsection

@section('content')
<main id="app" class="d-flex flex-nowrap">
    <example :buttons="buttons" avatar="{{ asset('src/img/avatars/' . Auth::user()->avatar) }}" user="{{ Auth::user()->name }} {{ Auth::user()->lastName }}" level="{{ Auth::user()->level }}" />
</main>
<div id="modals"></div>
<div id="alerts"></div>
<div id="import"></div>
@endsection

@section('scripts')
@parent
@vite(['resources/js/app.js'])
@endsection