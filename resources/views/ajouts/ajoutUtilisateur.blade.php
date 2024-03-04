@extends('layouts.fn')
@section('title', 'Ajouter un utilisateur')
@section('content')
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script>
    $(document).ready(function() {
        // Sélectionnez le champ source
        var champSource = $('#type');
        console.log(champSource.val());

        // Sélectionnez le champ cible à cacher
        var champCible = $('.info_eleve');

        // Cachez le champ cible au chargement de la page si nécessaire
        if (champSource.val() !== 'eleve') {
            champCible.hide();
        }

        // Détectez les changements dans le champ source
        champSource.change(function() {
            // Affichez ou cachez le champ cible en fonction de la valeur du champ source
            if ($(this).val() === 'eleve') {
                champCible.show();
            } else {
                champCible.hide();
            }
        });
    });
</script>

<div class="home_container container grid">
    <div class="home_content">
    <h2>Ajouter un utilisateur</h2>

    @if ($errors->any())
    <div class="alert alert-danger">
        <ul>
            @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
    @endif
        
        <form action="{{route('utilisateurs.store')}}" method = "POST" name="form_user" id="form_user" class="add_form">
            <fieldset>
            @csrf
            <label for="code">Code</label>
            <input name="code" type="text" id="code" placeholder="Code d'identification"></input>

            <label for="nom">Nom</label>
            <input name="nom" type="text" id="nom" placeholder="Nom de l'utilisateur"></input>

            <label for="prenom">Prénom</label>
            <input name="prenom" type="text" id="prenom" placeholder="Prénom de l'utilisateur"></input>

            <label for="email">Adresse e-mail</label>
            <input name="email" type="email" id="email" placeholder="Adresse e-mail"></input>

            <label for="password">Mot de passe </label>
            <input name="password" type="password" id="password" placeholder="Mot de passe (au moins 8 caractères,1 chiffre, 1 majuscule)"></input>

            <label for="confirm_password">Confirmer le mot de passe</label>
            <input name="confirm_password" type="password" id="password_confirm" placeholder="Entrez le même mot de passe"></input>

            <label for="type">Type d'utilisateur</label>
            <select name="type" id="type">
                @if($request->type == 'prof')
                    <option value="professeur">Professeur</option>
                @endif
                @if($request->type == 'eleve')
                    <option value="eleve">Éleve</option>
                @endif
            </select>

            <label for="groupe" class="info_eleve">Groupe</label>
            <select name="groupe" id="groupe" class="info_eleve">
                @foreach($listeGroupes as $groupe)
                    <option value="{{$groupe->id}}">
                        @if ($tabParcours[$groupe->id]!=null) 
                            {{$groupe->libelle." ".$tabParcours[$groupe->id]->semestre->libelle. " (".$tabParcours[$groupe->id]->semestre->id_annee.") "}}
                        @else
                            {{$groupe->libelle}}
                        @endif
                    </option>
                @endforeach
            </select>

            <input name="envoyer" type="submit" class="button" value="Enregistrer"></input>
            </fieldset>
        </form>

    </div>
</div>


@endsection