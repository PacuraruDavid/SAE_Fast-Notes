@extends('layouts.fn')

@section('title', 'Profil utilisateur')

@section('content')
<div class ="home_container container grid">
    <div class="home_content">
        <div class="spaced-div">
        @if ($errors->any())
    <div class="alert alert-danger">
        <ul>
            @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
    @endif
        <h2> Informations</h2>

        <h3> Code de connexion  : {{$utilisateur->code}}</h3>
        <h3> Nom  : {{$utilisateur->nom}}</h3>
        <h3> Prénom  : {{$utilisateur->prenom}}</h3>
        <h3> Adresse e-mail : {{$utilisateur->email}}</h3>
        <h3> Compte {{$role}} </h3>
        </div>
 

        <div class="spaced-div" id="profile-form">
        <h2> Changer le mot de passe </h2>
        <form method="post" action="{{ route('modifierMDP') }}" class="add_form profile-form" >
        @csrf
        <input type="hidden" name="code" value = "{{ $utilisateur->code }}">

        <fieldset>
            <label for="password">Mot de passe actuel</label>
            <input type="password" name="password"></input>
            
            @if($errors->has('mot_de_passe'))
            <span class="text-danger error-message">{{ $errors->first('mot_de_passe') }}</span>
            @endif
        </fieldset>

        <fieldset>

            <label for="new-password">Nouveau mot de passe</label>
            <input type="password" name="new-password"></input>

            <label for="confirm-password">Confirmer le mot de passe</label>
            <input type="password" name="confirm-password"></input>
        </fieldset>


        <button type="submit" class="button"  id="valider">Enregistrer le mot de passe</button>
        </form>
        </div>

        <div class="spaced-div">
            <h2> Notifications </h2>
            <form method="post" action="{{ route('modifierNotif') }}"  class="profile-form">
                @csrf
                <input type="hidden" name="code" value = "{{ $utilisateur->code }}">
                <input type="checkbox" id="notif" name="notif" @if ($utilisateur->notifications) checked @endif />
                <label for="notif">Autoriser les notifications par e-mail </label>
                <br>
                <button type="submit" class="button"  id="validerNotif" >Enregistrer la modification</button>
        </div>
    </div>
</div>

@endsection
