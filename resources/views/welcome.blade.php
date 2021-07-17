<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <title>Laravel</title>

        <!-- Fonts -->
        <link href="https://fonts.googleapis.com/css2?family=Nunito:wght@200;600&display=swap" rel="stylesheet">

        <!-- Styles -->
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
        <link rel="stylesheet" href="/access/css/style-certificate.css">
    </head>
    <body>
        <!-- <div class="flex-center position-ref full-height">
            @if (Route::has('login'))
                <div class="top-right links">
                    @auth
                        <a href="{{ url('/home') }}">Home</a>
                    @else
                        <a href="{{ route('login') }}">Login</a>

                        @if (Route::has('register'))
                            <a href="{{ route('register') }}">Register</a>
                        @endif
                    @endauth
                </div>
            @endif

            <div class="content">
                <div class="title m-b-md">
                    Laravel
                </div>

                <div class="links">
                    <a href="https://laravel.com/docs">Docs</a>
                    <a href="https://laracasts.com">Laracasts</a>
                    <a href="https://laravel-news.com">News</a>
                    <a href="https://blog.laravel.com">Blog</a>
                    <a href="https://nova.laravel.com">Nova</a>
                    <a href="https://forge.laravel.com">Forge</a>
                    <a href="https://vapor.laravel.com">Vapor</a>
                    <a href="https://github.com/laravel/laravel">GitHub</a>
                </div>
            </div>
        </div> -->
        
        <!-- <div style="text-align: center; padding: 10%;">
            <div class="row mt-5">
                <form action="{{ route('import.data') }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    <div class="form-group">
                        <label for="">Importar datos</label>
                        <input type="file" name="data" class="form-control">
                    </div>

                    <button type="submit" class="btn btn-primary mt-3" style="margin-top: 1rem;">importar</button>
                </form>
            </div>
        </div> -->

        <!-- <div id="content-main" class="text-center"> -->
        <div id="content-main" class="container mt-5">
            <h3 class="text-center">Aquí tienes una vista previa de tu certificado</h3>
            <p class="mt-4">Es necesario que puedas ingresar tu <strong>nombre</strong> y <strong>correo electrónico</strong> para verificar tus datos. Recuerda que solo tienes un intento para descargar tu certificado.</p>

            <div class="row mt-5">
                <div class="col-6">
                    <label for="" class="form-label">Nombre Completo</label>
                    <input type="text" class="form-control" id="name" placeholder="Tu Nombre" required>
                    <div id="name-valid" class="error"></div>
                </div>

                <div class="col-6">
                    <label for="" class="form-label">Email address</label>
                    <input type="email" class="form-control" id="email" placeholder="name@example.com">
                    <div id="email-valid" class="error"></div>
                </div>
            </div>

            <div class="text-center mt-5">
                <button id="btn-generate" class="btn btn-primary" style="margin-right: 3rem;">Generar Certificado</button>
                <a class="btn btn-secondary" href="https://congresopalmadeaceite.com">Regresar al Evento</a>
            </div>

            <div id="alert-certificate" class="mt-5" style="display: none">
                <div id="content-alert" class="alert alert-success" role="alert">Este es un alert</div>
            </div>

            <hr style="margin: 3rem 0;">

            <div id="content" style="position: relative">
                <img class="img-background-certificate" src="/access/image/background-certificate.jpg" alt="background certificate">
                <div id="content-certificate" class="text-center content-info">
                    <h1 class="title">Certificado de Asistencia</h1>
                    <h4 class="subtitle">Congreso Nacional virtual de Cultivadores de Palma de Aceite 2021 versión XLIX.</h4>
                    <div style="height: 3rem;"></div>
                    <p>Participante del evento:</p>
                    <h1 id="fullName" style="text-transform: uppercase;">Tu Nombre</h1>
                    <div style="height: 2rem;"></div>
                    <p>Fecha de asistencia:</p>
                    <h3>25 de Julio del 2021</h3>
                    <div style="height: 3rem;"></div>
                </div>
            </div>
        </div>
        
        <!-- <script src="https://raw.githack.com/eKoopmans/html2pdf/master/dist/html2pdf.bundle.js"></script> -->
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous"></script>
        <script src="/access/js/html2pdf.js"></script>
        <script src="/access/js/generate-pdf.js"></script>
    </body>
</html>
