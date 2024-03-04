@extends('layouts.fn')
@section('title', 'Fast Notes')
@section('content')
        <div class="home_container container grid">
        <div class="scroll_div_large">  
            <table class="eleve-tab scroll_table">
                <thead class="tab-row-dark">
                  <tr>   
                    <th>Code prof</th>
                    <th>Groupe</th>
                    <th>Ressource</th>
                    <th></th>
                  </tr> 
                </thead>
                @for ($i = 0; $i < count($tabEnseignements); $i++)
                  <tr class="tab-row tab-row-clear">
                    <td class="tab-cell" >{{ $tabEnseignements[$i]->code_prof}}</td>
                    <td class="tab-cell" >{{ $tabEnseignements[$i]->id_groupe}}</td>
                    <td class="tab-cell" >{{ $tabEnseignements[$i]->code_ressource}}</td>
                    <form method="post" action = "{{route ('supprimerEnseignement', ['prof'=>$tabEnseignements[$i]->code_prof, 'groupe'=>$tabEnseignements[$i]->id_groupe, 'ressource'=>$tabEnseignements[$i]->code_ressource]) }}">
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