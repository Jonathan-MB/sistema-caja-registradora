@extends('partials.principal')

@section('titulo')
    Registradora
@endsection

@section('css')
    <link rel="stylesheet" href="{{ asset('css/registro.css') }}">
@endsection


@section('contenido')
    <div>
        <form id="userInicioForm">
            @csrf
            <label for="ccNitInicio">Cédula o NIT</label>
            <input type="text" id="ccNitInicio" name="ccNitInicio" required>

            <button type="submit">Validar</button>
            <p>Validamos si el usuario está registrado.</p>
        </form>

        <div id="datosUser">
            <input type="text" id="userName" name="userName" placeholder="Nombre de usuario"readonly>
            <input type="text" id="userId" name="userId" placeholder="ID de usuario"readonly>
            <input type="text" id="typeId" name="typeId" placeholder="Tipo de usuario"readonly>
        </div>

    </div>

    <div class=" justify-content-center align-items-center contenedorCardInicio" id="registrarUser"
        style="min-height: 100vh; " ;>   {{--  <---- awui display none --}}
        <div class="card text-white bg-secondary mb-3 cardInicio">
            <div class="card-header d-flex justify-content-center align-items-center">
                <p class="tituloCard">Registro de Usuarios</p>
            </div>
            <div class="card-body">
                <div id="alertContainer"></div>
                <form id="userForm" class="d-flex flex-column align-items-center" action="{{ route('user.store') }}"
                    method="POST">
                    @csrf
                    <div class="mb-3 w-100">
                        <select class="form-select" aria-label="Default select example" id="tipoClienteSelect"
                            name="tipoClienteSelect">

                            <option>Tipo De Cliente</option>
                            <option value="1">Persona Natual</option>
                            <option value="2">Persona Juridica</option>

                        </select>

                        <label for="ccNit" id="ccNitLabel" class="form-label labelRegister">Cédula o NIT</label>
                        <input type="text" class="form-control no-spinner " id="ccNit" maxlength="10" name="ccNit"
                            required placeholder="XXXXXXXXX" disabled>

                        <label for="nombreLabel" class="form-label labelRegister">Nombre</label>
                        <input type="text" class="form-control no-spinner " id="nombre" maxlength="45" name="nombre"
                            required disabled>

                        <label for="razonSocialLabel" class="form-label labelRegister">Razón social</label>
                        <input type="text" class="form-control no-spinner " id="razonSocial" maxlength="45"
                            name="razonSocial" required disabled>
                    </div>

                    <button type="submit" class="btn btn-warning btnCard" id="registrar" disabled>Registrar</button>
                    <p class="textCard mt-3">Validamos si el usuario está registrado.</p>
                </form>
            </div>
        </div>
    </div>
@endsection



@section('scrips')

<script src="{{ asset('js/btnRegistrar.js') }}"></script>
<script src="{{ asset('js/inicio.js') }}"></script>
    <script src="{{ asset('js/registro.js') }}"></script>
@endsection
