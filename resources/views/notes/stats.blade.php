@extends('layouts.fn')
@section('title', 'Fast Notes')
@section('content')
        <div class="home_container container grid">
        <div class="home_content">
        <div style="display:flex; justify-content: center; align-items: center;">
        <h1>Statistiques de l'évaluation</h1>
        </div>
        <div style="display:flex; justify-content: center; align-items: center;">
        <img src="{{URL('./images/graph'.$evaluation->id.'.jpg')}}"><br>
        <?php
        if(isset($_GET["dl"])){
            $file='./images/graph'.$evaluation->id.'.jpg';
            header('Content-Description: File Transfer');
            header('Content-Type: image/jpeg');
            ob_clean();
            header('Content-Disposition: attachment; filename="'.basename($file).'"');
            header('Expires: 0');
            header('Cache-Control: must-revalidate');
            header('Pragma: public');
            header('Content-Length: ' . filesize($file));
            readfile($file);
            exit();
        }
        ?>
        </div>
        <div style="display:flex; justify-content: center; align-items: center;">
        <form method="GET">
            <button type="submit" class="button "name="dl">Télécharger le graphique</button>
        </form>
        </div>
        <div style="display:flex; justify-content: center; align-items: center;">
        <p>Moyenne : {{$stats['moyenne']}}</p>
        </div>
        <div style="display:flex; justify-content: center; align-items: center;">
        <p>Écart type : {{$stats['ecart_type']}}</p>
        </div>
        </div>
        </div>
@endsection