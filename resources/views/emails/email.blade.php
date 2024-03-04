<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />


    <!--  SWIPER CSS  -->
    <link rel="stylesheet" href="{{asset('assets/css/swiper-bundle.min.css')}}" />
    <!--  CSS  -->
    <link rel="stylesheet" href="{{asset('assets/css/styles.css')}}" />

    <title>Emails IUT</title>
</head>
<body>
    <h1>Mon super mail</h1>
    <form action="{{ route('envoyerNotif') }}" method="POST">
        @csrf
        <input type="hidden" name="idUtilisateur" value="eleveA">
        <input type="hidden" name="idEvaluation" value="572">
        <button type="submit" class="btn btn-link">Envoyer un e-mail</button>
    </form>
    
    
    
</body>
</html>