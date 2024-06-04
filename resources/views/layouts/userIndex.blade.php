@extends('partials.principal')

@section('titulo')
    Listado de Usuarios
@endsection

@section('css')
    <link rel="stylesheet" href="{{ asset('css/userIndex.css') }}">
@endsection

@section('contenido')
    <div class="d-flex justify-content-center align-items-center  contenedorCardInicio" style="min-height: 100vh;">
        <div class="card text-dark cardInicio m-0 w-75">
            <div class="card-header d-flex justify-content-between align-items-center bg-secondary">
                <p class="tituloCard">Listado de Usuarios</p>
                <form class="d-flex" action="{{ route('user.index') }}" method="GET">
                    @csrf
                    <input class="form-control me-2" type="search" name="search" placeholder="Nombre o Codigo"
                        aria-label="Search" value="{{ request('search') }}">
                        
                    <button class="btn btn-warning btnCard" type="submit">Buscar</button>
                </form>
                
                <form class="d-flex m-1" action="{{ route('user.index') }}" method="GET">
                    @csrf
                    <input class="form-control me-2" type="hidden" name="search2" placeholder="Nombre o Codigo"
                        aria-label="Search" value="{{ request('search') }}">
                    <button class="btn btn-warning btnCard2" type="submit">Todos</button>
                </form>
            </div>

            
            <div class="card-body">
                @if ($users->isEmpty())
                    <div class="alert alert-warning" role="alert">
                        No se encontraron useros.
                    </div>
                @else
                    <div class="table-responsive">
                        <table class="table table-hover">
                            <thead>
                                <tr>
                                    <th scope="col">Nombre</th>
                                    <th scope="col">CC_NIT</th>
                                    <th scope="col">Razon social</th>
                                    <th scope="col">Tipo Usuario</th>
                                    <th scope="col">Fecha de Creacion</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($users as $user)
                                    <tr  onclick="window.location='{{ route('user.show', $user->id) }}'">
                                        <td>{{ $user->user_name }}</td>
                                        <td>{{ $user->user_cc_nit }}</td>
                                        <td>{{ $user->user_business_name }}</td>
                                        <td>
                                            @if ($user->type_id == 1)
                                                Persona Natural
                                            @else
                                            Persona Juridica
                                            @endif
                                        </td>
                                        <td>{{ $user->created_at }}</td>


                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                    {{ $users->links('pagination::bootstrap-4') }}
                @endif
            </div>
        </div>
    </div>
@endsection
