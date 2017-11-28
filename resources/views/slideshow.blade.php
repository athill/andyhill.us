<!doctype html>
<html lang="{{ app()->getLocale() }}">
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="keywords" content="cf,metaprogramming"/>
        <meta name="description" content="ColdFusion Metaprogramming"/>
        <meta name="author" content="Andy Hill"/>
        <meta name="copyright" content="{{ date('Y') }}, andyhill.us"/>       
        <!-- Manifest -->
        <!-- <link rel="manifest" href="{{ asset('manifest.json') }}"> -->
        <meta name="theme-color" content="#000000"/>
        <!-- favicon -->
        <!-- <link href="/images/touch/andyhill_48x48.png" rel="shortcut icon" type="image/png"/> -->
   
        <title>ColdFusion Metaprogramming</title>
        <link href="/media/reveal/css/reveal.css" rel="stylesheet" type="text/css">
        <link href="/media/reveal/css/theme/black.css" rel="stylesheet" type="text/css">
    </head>
    <body>
        @yield('content')
        <script src="/media/reveal/js/reveal.js"></script>
		<script>
			Reveal.initialize();
		</script>        
    </body>
</html>