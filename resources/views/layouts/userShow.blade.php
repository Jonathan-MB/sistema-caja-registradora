@extends('partials.principal')

@section('titulo')
    Detalle del usero
@endsection

@section('css')
    <link rel="stylesheet" href="{{ asset('css/userDetalle.css') }}">
    

@endsection

@section('contenido')
    <div class="contenedorCardInicio">
        <div class="card text-white mb-3 cardInicio">
            <div class="card-header d-flex justify-content-center align-items-center">
                <p class="tituloCard">Detalle del usuario</p>
            </div>
            <div class="card-body">
                @if (session('error'))
                    <div class="alert alert-danger alert-dismissible fade show" role="alert">
                        {{ session('error') }}
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                    </div>
                @endif

                <p><strong>Nombre del Usuario :  </strong> {{ $user->user_name }}</p>
                <p><strong>Código del CC_nit :  </strong> {{ $user->user_cc_nit }}</p>
                <p><strong>Razon Social: </strong> {{ $user->user_business_name }}</p>
                <p><strong>Tipo de Usuario :  </strong> {{ $user->type_id }}</p>
                <p><strong>Fecha de actualizacion :  </strong> {{ $user->updated_at }}</p>
                <p><strong>Fecha de creacion :  </strong> {{ $user->created_at }}</p>

                <div class="d-flex justify-content-between">
                    <a href="{{ route('user.edit', ['user' => $user->id]) }}" class="btn btn-primary">Editar</a>
                    <a href="{{ route('user.index') }}" class="btn btn-secondary">Lista Usuarios</a>
                </div>
            </div>
        </div>
    </div>
@endsection

