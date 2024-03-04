@extends('layouts.fn')
@section('title', 'Fast Notes')
@section('content')
        <div class="home_container container grid">
          <div class="home_content">
          <div class="scroll_div_large">
            <table class="eleve-tab scroll_table">
                <thead class="tab-row-dark">
                  <tr>   
                    <th>Code élève</th>
                    <th>Nom élève</th>
                    <th>Prenom élève</th>
                    <th>Groupe</th>
                    <th>Parcours</th>
                    <th></th>
                    <th></th>
                  </tr> 
                </thead>
                @for ($i = 0; $i < count($tabEleves); $i++)
                  <tr class="tab-row tab-row-clear">
                    <td class="tab-cell" >{{ $tabEleves[$i]->code}}</td>
                    <td class="tab-cell" >{{ $tabEleves[$i]->utilisateur->nom}}</td>
                    <td class="tab-cell" >{{ $tabEleves[$i]->utilisateur->prenom}}</td>
                    <td class="tab-cell "> {{ optional($listeGroupes[$i])->libelle ?? '-' }} </td>
                    <td class="tab-cell" >{{ optional($listeGroupes[$i])->parcours ?? '-' }}</td>
                    <td class="tab-cell" ><a class="clear-cell button del-button " href="/pdf/{{ $tabEleves[$i]->code }}"> Télécharger le relevé de notes </a></td>
                    <form method="post" action = "{{route ('supprimerEleve', ['eleve'=>$tabEleves[$i]->code]) }}">
                      @csrf
                      @method('DELETE')
                      <td class="tab-cell "><button class="tab-cell clear-cell del-button " type="submit">Supprimer </button> </td>
                    </form>  
                  </tr>
                @endfor
            </table>
          </div>
          </div>
        </div>
@endsection