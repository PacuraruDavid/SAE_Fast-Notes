@extends('layouts.fn')
@section('title', 'Ajouter un semestre')
@section('content')

<div class="home_container container grid">
    <div class="home_content">
    <h2>Ajouter un semestre</h2>

    @if ($errors->any())
    <div class="alert alert-danger">
        <ul>
            @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
    @endif
        
        <form action="{{route('semestres.store')}}" method = "POST" name="form_sem" id="form_sem" class="add_form">
            <fieldset>
            @csrf

            <label for="numero">Numéro du semestre</label>
            <input name="numero" type="number" id="numero" placeholder="1">

            <select name="annee">
                @foreach($listeAnnees as $annee)
                    <option value="{{$annee->id_annee}}">{{$annee->id_annee}}</option>
                @endforeach
            </select>
            
            <input name="envoyer" type="submit" class="button" value="Enregistrer">
            </fieldset>
        </form>

    </div>
</div>


@endsection