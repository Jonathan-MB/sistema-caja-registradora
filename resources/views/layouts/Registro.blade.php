@extends('partials.principal')

@section('titulo')
    Registro
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
                <form id="userForm" class="d-flex flex-column align-items-center" action="{{ route('user.store') }}" method="POST">
                    @csrf
                    <div class="mb-3 w-100">
                        <select class="form-select" aria-label="Default select example" id="tipoClienteSelect" name="tipoClienteSelect">
                            <option value="" selected>Tipo De Cliente</option>
                            @foreach ($tiposCliente as $tipoCliente)
                                <option value="{{ $tipoCliente->id }}">{{ $tipoCliente->type_name }}</option>
                            @endforeach
                        </select>
                
                        <label for="ccNit" id="ccNitLabel" class="form-label labelRegister">Cédula o NIT</label>
                        <input type="text" class="form-control no-spinner " id="ccNit" maxlength="10" name="ccNit" required placeholder="XXXXXXXXX" disabled>
                
                        <label for="nombreLabel" class="form-label labelRegister">Nombre</label>
                        <input type="text" class="form-control no-spinner " id="nombre" maxlength="45" name="nombre" required disabled>
                
                        <label for="razonSocialLabel"  id="razonSocialLabel"  class="form-label labelRegister">Razón social</label>
                        <input type="text" class="form-control no-spinner " id="razonSocial" maxlength="45" name="razonSocial" required disabled>
                    </div>
                
                    <button type="submit" class="btn btn-warning btnCard" id="registrar" disabled>Registrar</button>
                    <p class="textCard mt-3">Validamos si el usuario está registrado.</p>
                </form>
            </div>
        </div>
    </div>
@endsection



@section('scrips')

<script src="{{asset('js/registro.js')}}"></script>
@endsection
