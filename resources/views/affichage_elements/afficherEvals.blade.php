@extends('layouts.fn')
@section('title', 'Fast Notes')
@section('content')
        <div class="home_container container grid">
          <div class="home_content">
          <div class="scroll_div_large">
            <table class="prof-tab note-tab scroll_table">
                <tr>
                    <th>Évaluation</th>
                    <th>Coefficient</th>
                    <th>Type</th>
                    <th>Date épreuve</th>
                    <th>Date rattrapage</th>
                    <th>Code ressource</th>
                    
                </tr>
                @for ($i = 0; $i < count($tabEvals); $i++)
                  <tr class="tab-row tab-row-clear">
                    <td class="tab-cell" >{{ $tabEvals[$i]->libelle}}</td>
                    <td class="tab-cell" >{{ $tabEvals[$i]->coefficient }}</td>
                    <td class="tab-cell "> {{ $tabEvals[$i]->type }} </td>
                    <td class="tab-cell" >{{ $tabEvals[$i]->date_epreuve }}</td>
                    <td class="tab-cell" >{{ $tabEvals[$i]->date_rattrapage }}</td>
                    <td class="tab-cell" >{{ $tabEvals[$i]->code_resource }}</td>
                    <form method="post" action = "{{route ('supprimerEval', ['eval'=>$tabEvals[$i]->id]) }}">
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