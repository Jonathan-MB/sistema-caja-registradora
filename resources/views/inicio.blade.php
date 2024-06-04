@extends('partials.principal')

@section('titulo')
    Registradora
@endsection

@section('css')

@endsection




@section('contenido')
    {{-- elimina las variables de sesion viejas  --}}



    <div class="d-flex justify-content-center align-items-center contenedorCardInicio" style="min-height: 100vh;">
        <div class="card text-white bg-secondary mb-3 cardInicio">
            <div class="card-header d-flex justify-content-center align-items-center">
                <p class="tituloCard">Identificación Usuario</p>
            </div>
            <div class="card-body">
                <div id="alertContainer"></div>

                {{-- elimina las sessiones --}}



                <form id="userForm" class="d-flex flex-column align-items-center"
                    action="{{ route('user.validateUser') }} "method="POST">
                    @csrf
                    <div class="mb-3 w-100">
                        <label for="ccNit" class="form-label centerInCard">Cédula o NIT</label>
                        <input type="text" class="form-control no-spinner ccNitInput" id="ccNit" name="ccNit"
                            required placeholder="XXXXXXXXX">
                    </div>

                    <button type="submit" class="btn btn-warning btnCard" id="validar">Validar</button>
                    <p class="textCard mt-3">Validamos si el usuario está registrado antes de hacer la compra.</p>


                </form>
            </div>
        </div>
    </div>
@endsection



@section('scrips')
    <script src="{{ asset('js/inicio.js') }}"></script>
@endsection
