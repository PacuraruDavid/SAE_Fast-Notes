@extends('layouts.fn')
@section('title', 'Ajouter un parcours')
@section('content')

<div class="home_container container grid">
    <div class="home_content">
    <h2>Ajouter un parcours</h2>

    @if ($errors->any())
    <div class="alert alert-danger">
        <ul>
            @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
    @endif
        
        <form action="{{route('parcours.store')}}" method = "POST" name="form_parcours" id="form_parcours" class="add_form">
            <fieldset>
            @csrf

            <label for="id">Libellé</label>
            <input name="id" type="text" id="id" placeholder="Libellé"></input>

            <label for="semestre">Semestre</label>
            <select name="semestre">
                @foreach($listeSemestres as $semestre)
                    <option value="{{$semestre->id_semestre}}">{{$semestre->id_semestre. " ".$semestre->libelle}}</option>
                @endforeach
            </select>
            
            <input name="envoyer" type="submit" class="button" value="Enregistrer"></input>
            </fieldset>
        </form>

    </div>
</div>

@endsection