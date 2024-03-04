@extends('layouts.fn')
@section('title', 'Fast Notes')
@section('content')
        <div class="home_container container full_home">
          <div class="home_content full_home center">
            @auth
              <div class="items_admin flex_forms">
                <div class="flex_divs">
                  <p style="margin-top:10px;color:white;">Gestion des années</p> <br>
                  <a class="tab-cell button button-admins" href="{{ route('annees.index') }}">Afficher les années</a><br>
                  <a class="tab-cell button button-admins" href="{{ route('annees.create') }}">Ajouter une année</a><br>
                  <a class="tab-cell button button-admins" href="{{route('ajoutAnnees')}}">Ajouter des années</a><br>
                </div>
                <div class="flex_divs">
                  <p style="margin-top:10px;color:white;">Gestion des semestres</p> <br>
                  <a class="tab-cell button button-admins" href="{{ route('afficherSemestres') }}" >Afficher les semestres</a><br>
                  <a class="tab-cell button button-admins" href="{{ route('semestres.create') }}">Ajouter un semestre</a><br>
                  <a class="tab-cell button button-admins" href="{{ route('ajoutSemestre') }}">Ajouter des semestres</a><br>
                </div>
                <div class="flex_divs">
                  <p style="margin-top:10px;color:white;">Gestion des parcours</p> <br>
                  <a class="tab-cell button button-admins" href="{{ route('afficherParcours') }}">Afficher les parcours</a><br>
                  <a class="tab-cell button button-admins" href="{{ route('parcours.create') }}">Ajouter un parcours</a><br>
                  <a class="tab-cell button button-admins" href="{{route('ajoutsParcours')}}">Ajouter des parcours</a><br>
                </div>
                <div class="flex_divs">
                  <p style="margin-top:10px;color:white;">Gestion des groupes</p> <br>
                  <a class="tab-cell button button-admins" href="{{ route('afficherGroupes') }}">Afficher les groupes</a><br>
                  <a class="tab-cell button button-admins" href="{{route('groupes.create')}}">Ajouter un groupe</a><br>
                  <a class="tab-cell button button-admins" href="{{ route('ajoutGroupe') }}">Ajouter des groupes</a><br>
                </div>
                <div class="flex_divs">
                  <p style="margin-top:10px;color:white;">Gestion des élèves</p> <br>
                  <a class="tab-cell button button-admins" href="{{ route('afficherEleves') }}">Afficher les élèves</a><br>
                  <a class="tab-cell button button-admins" href="/ajoutUtilisateur?type=eleve">Ajouter un élève</a><br>
                  <a class="tab-cell button button-admins" href="{{ route('ajoutEleve') }}">Ajouter des élèves</a>
                </div>
                <div class="flex_divs">
                  <p style="margin-top:10px;color:white;">Gestion des UE</p> <br>
                  <a class="tab-cell button button-admins" href="{{ route('ue.index') }}">Afficher les UE</a><br>
                  <a class="tab-cell button button-admins" href="{{ route('ue.create')}}">Ajouter une UE</a><br>
                  <a class="tab-cell button button-admins" href="{{ route('ajoutUE') }}">Ajouter des UE</a><br>
                </div>
                <div class="flex_divs">
                  <p style="margin-top:10px;color:white;">Gestion des ressources</p> <br>
                  <a class="tab-cell button button-admins" href="{{ route('afficherRessources') }}">Afficher les ressources</a><br>
                  <a class="tab-cell button button-admins" href= "{{ route('ressource.create') }}">Ajouter une ressource</a><br>
                  <a class="tab-cell button button-admins" href="{{ route('ajoutRessource') }}">Ajouter des ressources</a><br>
                </div>
                <div class="flex_divs">
                  <p style="margin-top:10px;color:white;">Gestion des évaluations</p> <br>
                  <a class="tab-cell button button-admins" href="{{ route('afficherEvals') }}">Afficher les évaluations</a><br>
                  <a class="tab-cell button button-admins" href="{{ route('evaluation.create') }}">Ajouter une évaluation</a><br>
                  <a class="tab-cell button button-admins" href="{{ route('ajoutEval') }}">Ajouter des évaluations</a><br>
                </div>
                <div class="flex_divs">
                  <p style="margin-top:10px;color:white;">Gestion des professeurs</p> <br>
                  <a class="tab-cell button button-admins" href="{{ route('profs.index') }}">Afficher les professeurs</a><br>
                  <a class="tab-cell button button-admins" href="/ajoutUtilisateur?type=prof">Ajouter un professeur</a><br>
                  <a class="tab-cell button button-admins" href="{{route('ajoutProfs')}}">Ajouter des professeurs</a><br>
                </div>
                <div class="flex_divs">
                  <p style="margin-top:10px;color:white;">Gestion des enseignements</p> <br>
                  <a class="tab-cell button button-admins" href="{{ route('afficherEns') }}">Afficher les enseignements</a><br>
                  <br>
                  <a class="tab-cell button button-admins" href="{{route('ajoutEnseignements')}}">Ajouter des enseignements</a><br>
                </div>
              </div>
            @endauth
          </div>
        </div>
@endsection