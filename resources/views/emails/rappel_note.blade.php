<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Rappel de Saisie des Notes</title>
</head>
<body>
    <p>Bonjour {{ $prenom }} {{ $nom }},</p>
    
    <p>Nous vous rappelons que vous n'avez pas encore saisi toutes les notes pour l'évaluation "{{ $libelle_eval }}" du groupe "{{ $nom_groupe }}".</p>

    <p>Veuillez remplir les notes manquantes sur notre plateforme : <a href="http://127.0.0.1:8000">Fast Notes</a>.</p>

    <p>Cordialement,<br>
    L'équipe Fast Notes</p>
</body>
</html>
