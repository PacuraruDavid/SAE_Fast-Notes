@extends('layouts.fn')
@section('title', 'Fast Notes')
@section('content')
        <div class="home_container container grid">
          <div class="scroll_div_large">
            <table class="eleve-tab scroll_table">
                <thead class="tab-row-dark">
                  <tr>   
                    <th>Titre</th>
                    <th>Année du semestre</th>
                    <th></th>
                  </tr> 
                </thead>
                @for ($i = 0; $i < count($tabSemestres); $i++)
                  <tr class="tab-row tab-row-clear">
                    <td class="tab-cell" >{{ $tabSemestres[$i]->libelle}}</td>
                    <td class="tab-cell" >{{ $tabSemestres[$i]->id_annee}}</td>  
                    <form method="post" action = "{{route ('supprimerSemestre', ['semestre'=>$tabSemestres[$i]->id_semestre]) }}">
                      @csrf
                      @method('DELETE')
                      <td class=" "><button class="clear-cell button del-button " type="submit">Supprimer </button> </td>
                    </form>  

                  </tr>
                @endfor
            </table>
          </div>
        </div>
@endsection