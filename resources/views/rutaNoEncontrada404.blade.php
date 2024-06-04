<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Página no encontrada</title>

    <link href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
<link rel="stylesheet" href="{{asset('css/rutaNoEncontrada404.css')}}">

</head>

<body>
    <div class="container">
        <div class="row">
            <div class="col-md-12">
                <div class="mensaje-container">
                    <h1>404</h1>
                    <p>La página que buscas no existe.</p>
                    <a href="{{asset('/')}}" class="btn btn-primary">Ir al inicio</a>
                </div>
            </div>
        </div>
    </div>
</body>

</html>
