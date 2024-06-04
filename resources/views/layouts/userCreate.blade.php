@extends('partials.principal')

@section('titulo')
    Registro Usuarios
@endsection

@section('css')
    <link rel="stylesheet" href="{{ asset('css/registro.css') }}">
@endsection


@section('contenido')
    <div class="d-flex justify-content-center align-items-center contenedorCardInicio" style="min-height: 100vh;">
        <div class="card text-white bg-secondary mb-3 cardInicio">
            <div class="card-header d-flex justify-content-center align-items-center">
                <p class="tituloCard">Registro de Usuarios</p>
            </div>
            <div class="card-body">
                <div id="alertContainer"></div>

                @if (session('error'))
                    <div class="alert alert-danger alert-dismissible fade show" role="alert">
                        {{ session('error') }}
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                    </div>
                @endif




                <form id="userForm" class="d-flex flex-column align-items-center" action="{{ route('user.store') }}"
                    method="POST">
                    @csrf
                    <div class="mb-3 w-100">
                        <select class="form-select" aria-label="Default select example" id="tipoClienteSelect"
                            name="tipoClienteSelect">
                            <option value="" selected>Tipo De Cliente</option>
                            @foreach ($tiposCliente as $tipoCliente)
                                <option value="{{ $tipoCliente->id }}"
                                    {{ old('tipoClienteSelect') == $tipoCliente->id ? 'selected' : '' }}>
                                    {{ $tipoCliente->type_name }}
                                </option>
                            @endforeach
                        </select>
                        @error('tipoClienteSelect')
                            <p>{{ $errors->first('tipoClienteSelect') }}</p>
                        @enderror

                        <label for="ccNit" id="ccNitLabel" class="form-label labelRegister">Cédula o NIT</label>
                        <input type="text" class="form-control no-spinner " id="ccNit" maxlength="10" name="ccNit"
                            value="{{ old('ccNit') }}" required placeholder="XXXXXXXXX" disabled>
                        @error('ccNit')
                            <p>{{ $errors->first('ccNit') }}</p>
                        @enderror

                        <label for="nombreLabel" class="form-label labelRegister">Nombre</label>
                        <input type="text" class="form-control no-spinner " id="nombre" maxlength="45" name="nombre"
                            value="{{ old('nombre') }}" required disabled>
                        @error('nombre')
                            <p>{{ $errors->first('nombre') }}</p>
                        @enderror

                        <label for="razonSocialLabel" id="razonSocialLabel" class="form-label labelRegister">Razón
                            social</label>
                        <input type="text" class="form-control no-spinner " id="razonSocial" maxlength="45"
                            value="{{ old('razonSocial') }}" name="razonSocial" required disabled>
                        @error('razonSocial')
                            <p>{{ $errors->first('razonSocial') }}</p>
                        @enderror
                    </div>

                    <button type="submit" class="btn btn-warning btnCard" id="registrar" disabled>Registrar</button>

                </form>
            </div>
        </div>
    </div>
@endsection



@section('scrips')
    <script src="{{ asset('js/userCreate.js') }}"></script>
@endsection
