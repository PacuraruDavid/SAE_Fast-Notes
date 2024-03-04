@extends('layouts.fn')
@section('title', 'Fast Notes')
@section('content')
        <div class="home_container container grid">
          <div class="home_content">
            @auth
              <form action="{{ route('importRessources') }}" method="POST" enctype="multipart/form-data">
                @csrf
                <label for="file"> Sélectionner un fichier : </label>
                <input type="file" name="file" id="file">
                <button class="Entreprise button button-order" type="submit"> Ajouter des ressources </button>
              </form>
            @endauth
          </div>
        </div>
@endsection