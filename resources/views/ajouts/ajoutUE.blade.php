@extends('layouts.fn')
@section('title', 'Ajouter une UE')
@section('content')

<div class="home_container container grid">
    <div class="home_content">
    <h2>Ajouter une UE </h2>

    @if ($errors->any())
    <div class="alert alert-danger">
        <ul>
            @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
    @endif
        
        <form action="{{route('ue.store')}}" method = "POST" name="form_ue" id="form_ue" class="add_form">
            <fieldset>
            @csrf
            <label for="code">Code</label>
            <input name="code" type="text" id="code" placeholder="Code d'identification"></input>

            <label for="libelle">Libellé</label>
            <input name="libelle" type="text" id="libelle" placeholder="Libellé de l'UE"></input>

            <label for="competence">Compétence</label>
            <select name="competence">
                @foreach($listeCompetences as $competence)
                    <option value="{{$competence->code}}">{{$competence->libelle}}</option>
                @endforeach
            </select>

            <label from="semestre">Semestre</label>
            <select name="semestre">
                @foreach($listeSemestres as $semestre)
                    <option value="{{$semestre->id_semestre}}">{{$semestre->libelle. " ".$semestre->id_annee}}</option>
                @endforeach
            </select>
            
            <input name="envoyer" type="submit" class="button" value="Enregistrer"></input>
            </fieldset>
        </form>

    </div>
</div>


@endsection