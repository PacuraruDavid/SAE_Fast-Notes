<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Relevé de notes</title>
    <style>
        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
        }

        th, td {
            border: 1px solid #ddd;
            padding: 7px;
            text-align: left;
        }

        th {
            background-color: #f2f2f2;
        }
    </style>
</head>
<body>

    <h2>Relevé de notes de {{$prenom}} {{$nom}}</h2>

    <table>
        <thead>
            <tr>
                <th>Ressource</th>
                <th>Moyenne</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($tabMoyennesRessources as $ressource )
                <tr>
                    <td>{{ $ressource[0] }}</td>
                    <td>{{ $ressource[1] }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>

    <table>
        <thead>
            <tr>
                <th>Compétence</th>
                <th>Moyenne</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($tabMoyennesCompetences as $key => $valeur )
                <tr>
                    
                    <td>{{ $key }}</td>
                    <td>{{ $valeur }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>

    <p>Moyenne du semestre : {{ $moyenneSemestre }}</p>

</body>
</html>