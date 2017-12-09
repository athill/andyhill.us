<!doctype html>
<html lang="{{ app()->getLocale() }}">
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="keywords" content="andy hill,andy,hill,developer,iu"/>
        <meta name="description" content="andyhill.us, home page for Andy Hill"/>
        <meta name="author" content="Andy Hill"/>
        <meta name="copyright" content="{{ date('Y') }}, andyhill.us"/>       
        <!-- Manifest -->
        <!-- <link rel="manifest" href="{{ asset('manifest.json') }}"> -->
        <meta name="theme-color" content="#000000"/>
        <!-- favicon -->
        <link href="/images/icons/icon_48x48.png" rel="shortcut icon" type="image/png"/>
        <meta name="csrf-token" content="{{ csrf_token() }}">
   
        <title>andyhill.us</title>
        <link href="{{mix('css/app.css')}}" rel="stylesheet" type="text/css">
    </head>
    <body>
        <div id="app"></div>
        <script src="{{mix('js/app.js')}}" ></script>
    </body>
</html>