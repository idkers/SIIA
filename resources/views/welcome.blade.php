@extends('layouts.app')
@section('title', 'Inicio — SIIA')

@section('content')

<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">{{ __('Bienvenido a SIIA') }}</div>

                <div class="card-body">
                    {{ __('¡Gracias por usar SIIA!') }}
                </div>
            </div>
        </div>
    </div>
@endpush

@endsection