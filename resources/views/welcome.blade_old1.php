@extends('layouts.app')

<!doctype html>
<html lang="{{ app()->getLocale() }}">
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title>Image Gallery</title>
        <link href="https://fonts.googleapis.com/css?family=Raleway:100,600" rel="stylesheet" type="text/css">
        <link href="{{ asset('css/app.css') }}" rel="stylesheet"/>
    </head>
    <body>

        Ezt is kölön Codester kódként:<br>
make:auth <br>
belépéssel saját törlés <br>
pager <br>
tabs <br>
CSak képet lehet feltölteni <br>
        <div class="container" id="app">
            <image-component></image-component>

        </div>
    <script>
       window.Laravel = <?php echo json_encode([
	'csrfToken' => csrf_token(),
]); ?>


    </script>
    <script src="{{asset('js/app.js')}}"></script>
    </body>
</html>