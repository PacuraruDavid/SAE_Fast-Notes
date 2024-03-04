@extends('layouts.fn')
@section('title', 'Fast Notes')
@section('content')
        <div class="home_container container grid">
        <div class="scroll_div_large">  
          <table class="eleve-tab scroll_table">
                <thead class="tab-row-dark">
                  <tr>   
                    <th>Nom</th>
                    <th>Parcours</th>
                    <th></th>
                    <th></th>
                  </tr> 
                </thead>
                @for ($i = 0; $i < count($tabGroupes); $i++)
                  <tr class="tab-row tab-row-clear">
                    <td class="tab-cell" >{{ $tabGroupes[$i]->id}}</td>
                    <td class="tab-cell" >{{ $tabGroupes[$i]->parcours}}</td>  
                    <td><a class="clear-cell button del-button " href="afficherGroupesInfo?groupe={{ $tabGroupes[$i]->id}}">Afficher les informations du groupe </a> </td>
                    <form method="post" action = "{{route ('supprimerGroupe', ['groupe'=>$tabGroupes[$i]->id]) }}">
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