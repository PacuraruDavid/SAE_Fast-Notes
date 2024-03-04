<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Notification de Note</title>
</head>
<body>
    <p>Bonjour {{ $prenom }} {{ $nom }},</p>
    
    <p>Nous vous informons que vous avez obtenu la note de "{{ $note }}" en "{{ $libelle_eval }}".</p>

    <p>Vous pouvez consulter vos résultats sur notre plateforme : <a href="http://127.0.0.1:8000">Fast Notes</a>.</p>

    <p>Cordialement,<br>
    L'équipe Fast Notes</p>
</body>
</html>
