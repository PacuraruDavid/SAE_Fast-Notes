@extends('layouts.fn')
@section('title', 'Fast Notes')
@section('content')
        <div class="home_container container grid">
        <div class="home_content">
            <h2>Ajouter une Année </h2>
            @if ($errors->any())
            <div class="alert alert-danger">
                <ul>
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
            @endif
        
            <form action="{{route('annees.store')}}" method = "POST" name="form_ue" id="form_ue" class="add_form">
                <fieldset>
                @csrf
                <label for="adeb">Année de début</label>
                <input name="adeb" type="number" id="adeb" placeholder="Année de début"></input>

                <label for="afin">Année de fin</label>
                <input name="afin" type="number" id="afin" placeholder="Année de fin"></input>

                <input name="envoyer" type="submit" class="button" value="Enregistrer"></input>
                </fieldset>
            </form>
        </div>
@endsection