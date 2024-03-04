@extends('layouts.fn')
@section('title', 'Ajouter une évaluation')
@section('content')

<div class="home_container container grid">
    <div class="home_content">
    <h2>Ajouter une évaluation</h2>

    @if ($errors->any())
    <div class="alert alert-danger">
        <ul>
            @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
    @endif
        
        <form action="{{route('evaluation.store')}}" method = "POST" name="form_eval" id="form_eval" class="add_form">
            <fieldset>
            @csrf

            <label for="libelle">Libellé</label>
            <input name="libelle" type="text" id="libelle" placeholder="Libellé"></input>

            <label for="coefficient">Coefficient</label>
            <input name="coefficient" type="number" step=".1" id="coefficient" placeholder="Coefficient de l'évaluation"></input>

            <label for="type">Type</label>
            <input name="type" type="text" id="type" placeholder="Type de l'évaluation"></input>

            <label for="date_epreuve">Date de l'épreuve</label>
            <input name="date_epreuve" type="date" id="date_epreuve" placeholder="Date de l'épreuve"></input>

            <label for="date_rattrapage">Date du rattrapage (facultatif)</label>
            <input name="date_rattrapage" type="date" id="date_rattrapage" placeholder="Date du rattrapage (facultatif)"></input>

            <select name="ressource">
                @foreach($listeRessources as $ressource)
                    <option value="{{$ressource->code}}">{{$ressource->code. " ".$ressource->libelle}}</option>
                @endforeach
            </select>
            


            <input name="envoyer" type="submit" class="button" value="Enregistrer"></input>
            </fieldset>
        </form>

    </div>
</div>


@endsection