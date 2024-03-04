@extends('layouts.fn')
@section('title', 'Fast Notes')
@section('content')
        <div class="home_container container grid">
          <div class="scroll_div_large">  
            <table class="eleve-tab scroll_table">
                <thead class="tab-row-dark">
                  <tr>   
                    <th>Parcours</th>
                    <th>Semestre</th>
                    <th>Année</th>
                    <th></th>
                  </tr> 
                </thead>
                @for ($i = 0; $i < count($tabParcours); $i++)
                  <tr class="tab-row tab-row-clear">
                    <td class="tab-cell" >{{ $tabParcours[$i]->id_parcour}}</td>
                    <td class="tab-cell "> {{ $listeSemestres[$i]->libelle }} </td>
                    <td class="tab-cell "> {{ $listeSemestres[$i]->id_annee }} </td> 
                    <form method="post" action = "{{route ('supprimerParcours', ['id'=>$tabParcours[$i]->id_parcour]) }}">
                      @csrf
                      @method('DELETE')
                      <td class="tab-cell"><button class="clear-cell button del-button " type="submit">Supprimer </button> </td>
                    </form>
                  </tr>
                @endfor
            </table>
          </div>
        </div>
@endsection