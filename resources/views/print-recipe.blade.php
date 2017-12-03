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
        <!-- favicon -->
        <!-- <link href="/images/touch/andyhill_48x48.png" rel="shortcut icon" type="image/png"/> -->
        <meta name="csrf-token" content="{{ csrf_token() }}">
   
        <title>andyhill.us -- {{ $recipe['title'] }}</title>
        <link href="{{mix('css/app.css')}}" rel="stylesheet" type="text/css">
        <style type="text/css">
        body {
            color: black;
            background-color: white;
        }    
        h5 {
            margin-bottom: 0.5em;
            font-weight: bold;
        }
        </style>
    </head>
    <body>
        <div id="recipe-{{ $recipe['id'] }}" class="recipe">
           <h4 class="recipe-title recipe-background">{{ $recipe['title'] }}</h4>
           <div class="recipe-main recipe-background">
              <dl class="recipe-meta dl-horizontal">
                 <div>
                    <dt>Category</dt>
                    <dd>{{ $recipe['category'] }}</dd>
                 </div>
                 <div>
                    <dt>Cuisine</dt>
                    <dd>{{ $recipe['cuisine'] }}</dd>
                 </div>
                 <div>
                    <dt>Rating</dt>
                    <dd>{{ $recipe['rating'] }}</dd>
                 </div>
                 <div>
                    <dt>Prep Time</dt>
                    <dd>{{ $recipe['preptime'] }}</dd>
                 </div>
                 <div>
                    <dt>Servings</dt>
                    <dd>{{ $recipe['servings'] }}</dd>
                 </div>
                 <div>
                    <dt>Cook Time</dt>
                    <dd>{{ $recipe['cooktime'] }}</dd>
                 </div>
              </dl>
              <h5>Ingredients:</h5>
              <div class="container-fluid recipe-ingredients">
                @foreach ($recipe['ingredients'] as $ingredient)
                     <div class="row">
                        <div class="col-md-6 col-sm-12">
                           <div class="row">
                              <div class="col-xs-2">{{ $ingredient['amount'] }}</div>
                              <div class="col-xs-2">{{ $ingredient['unit'] }}</div>
                              <div class="col-xs-8">{{ $ingredient['item'] }}</div>
                           </div>
                        </div>
                     </div>
                 @endforeach
              </div>
              <h5>Instructions:</h5>
              @foreach ($recipe['instructions'] as $instruction)
                <div>{{ $instruction }}</div>
              @endforeach
              @isset($recipe['notes'])
                <h5>Notes:</h5>
                  @foreach ($recipe['notes'] as $note)
                    <div>{{ $note }}</div>
                  @endforeach                
              @endisset
           </div>
        </div>        
    </body>
</html>