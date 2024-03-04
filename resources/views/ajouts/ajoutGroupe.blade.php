@extends('layouts.fn')
@section('title', 'Ajouter un utilisateur')
@section('content')


<div class="home_container container grid">
    <div class="home_content">
    <h2>Ajouter un groupe</h2>

    @if ($errors->any())
    <div class="alert alert-danger">
        <ul>
            @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
    @endif
        
        <form action="{{route('groupes.store')}}" method = "POST" name="form_user" id="form_user" class="add_form">
            <fieldset>
            @csrf
            <label for="libelle">Libellé</label>
            <input name="libelle" type="text" id="libelle" placeholder="Libellé du groupe "></input>


            <label for="parcours">Parcours du groupe</label>
            <select name="parcours" id="parcours">
                @foreach ($listeParcours as $parcours)
                    <option value="{{$parcours->id_parcour}}">{{$parcours->id_parcour." ".$parcours->semestre->libelle." ".$parcours->semestre->id_annee}}</option>
                @endforeach
            </select>

            <input name="envoyer" type="submit" class="button" value="Enregistrer"></input>
            </fieldset>
        </form>

    </div>
</div>


@endsection