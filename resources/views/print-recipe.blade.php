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
            background-color: white !important;
            margin: 4em;
        }
        h5 {
            margin-bottom: 0.5em;
            font-weight: bold;
        }
        .recipe-meta th {
            padding-right: 1em;
        }
        </style>
    </head>
    <body>
        <div id="recipe-{{ $recipe['id'] }}" class="recipe">
           <h4 class="recipe-title recipe-background">{{ $recipe['title'] }}</h4>
           <div class="recipe-main recipe-background">
              <table class="recipe-meta">
               <tbody>
               <tr>
                  <th>Category</th>
                  <td>{{ $recipe['category'] }}</td>
               </tr>
               <tr>
                  <th>Cuisine</th>
                  <td>{{ $recipe['cuisine'] }}</td>
               </tr>
               <tr>
                  <th>Rating</th>
                  <td>{{ $recipe['rating'] }}</td>
               </tr>
               <tr>
                  <th>Prep Time</th>
                  <td>{{ $recipe['preptime'] }}</td>
               </tr>
               <tr>
                  <th>Servings</th>
                  <td>{{ $recipe['servings'] }}</td>
               </tr>
               <tr>
                  <th>Cook Time</th>
                  <td>{{ $recipe['cooktime'] }}</td>
               </tr>
               <tbody>
              </table>
              <h5>Ingredients:</h5>
              <div class="container-fluid recipe-ingredients">
                @foreach ($recipe['ingredients'] as $ingredient)
                     <div class="row">
                        <div class="col-md-6 col-sm-12">
                           <div class="row">
                              <div class="col-xs-2">{{ isset($ingredient['amount']) ? $ingredient['amount'] : '' }}</div>
                              <div class="col-xs-2">{{ isset($ingredient['unit']) ? $ingredient['unit'] : '' }}</div>
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
