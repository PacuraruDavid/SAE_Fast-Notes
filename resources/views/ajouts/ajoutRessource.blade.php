@extends('layouts.fn')
@section('title', 'Ajouter une Ressource')
@section('content')

<div class="home_container container grid">
    <div class="home_content">
    <h2>Ajouter une Ressource </h2>
    @if ($errors->any())
    <div class="alert alert-danger">
        <ul>
            @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
    @endif
        
        <form action="{{route('ressource.store')}}" method = "POST" name="form_ue" id="form_ue" class="add_form">
            <fieldset>
            @csrf
            <label for="code">Code</label>
            <input name="code" type="text" id="code" placeholder="Code d'identification"></input>

            <label for="libelle">Libellé</label>
            <input name="libelle" type="text" id="libelle" placeholder="Libellé de la ressource"></input>

            <label for="competence">Compétence</label>
            <select name="competence" style="margin-bottom:15px;">
                @foreach($listeCompetences as $competence)
                    <option value="{{$competence->code}}">{{$competence->libelle}}</option>
                @endforeach
            </select>

            <label for="coef">Coefficient</label>
            <input name="coef" type="number" id="coef" placeholder="Coefficient de la ressource dans la compétence" min=0 max=1 step="0.01"></input>
            
            <input name="envoyer" type="submit" class="button" value="Enregistrer"></input>
            </fieldset>
        </form>

    </div>
</div>


@endsection