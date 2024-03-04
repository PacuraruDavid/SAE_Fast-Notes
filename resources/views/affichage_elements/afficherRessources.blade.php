@extends('layouts.fn')
@section('title', 'Fast Notes')
@section('content')
        <div class="home_container container grid">
          <div class="scroll_div_large">
            <table class="eleve-tab scroll_table">
                <thead class="tab-row-dark">
                  <tr>   
                    <th>Nom</th>
                    <th>Code</th>
                    <th></th>
                  </tr> 
                </thead>
                @for ($i = 0; $i < count($tabRessources); $i++)
                  <tr class="tab-row tab-row-clear">
                    <td class="tab-cell" >{{ $tabRessources[$i]->libelle}}</td>
                    <td class="tab-cell" >{{ $tabRessources[$i]->code}}</td>   
                    <form method="post" action = "{{route ('supprimerRessource', ['ressource'=>$tabRessources[$i]->code]) }}">
                      @csrf
                      @method('DELETE')
                      <td class="tab-cell "><button class="tab-cell clear-cell del-button " type="submit">Supprimer </button> </td>
                    </form>
                  </tr>
                @endfor
            </table>
          </div>
        </div>
@endsection