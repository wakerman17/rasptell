<!doctype html>
<html lang="{{ app()->getLocale() }}">
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <link rel="stylesheet" href="{{asset('css/app.css')}}"
        <title>{{config('App.name')}}</title>
        <title>Rasptell</title>
    </head>
    <body>
      <div class="topnav">
        <a href="/">Home</a>
      <a href="/register">Register</a>
        <a href="/control">Control</a>
    </div>
      <h1>This is the Register Page!</h1>
      <h3>Here you can register</h3>
    </body>
</html>
