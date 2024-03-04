@extends('layouts.fn')

@section('title', 'Liste UEs ')

@section('content')


        <div class="home_container container grid">
          <div class="home_content">
          <div class="scroll_div_large">
            <table class="UE_tab">
              <thead class="tab-row-dark">
                  <tr>
                      <th>Code UE</th>
                      <th>Libellé UE</th>
                      <th>Code compétence</th>
                      <th>Libellé compétence</th>
                      <th>Libellé semestre</th>
                      <th>Période </th>
                      <th class="tab-cell"></th>
                  </tr>
                </thead>
                <tbody>
                @for ($i = 0; $i < count($tabUE); $i++)
                    <tr class="tab-row tab-row-clear">
                      <td class="tab-cell" >{{ $tabUE[$i]->code}}</td>
                      <td class="tab-cell" >{{ $tabUE[$i]->libelle}}</td>
                      <td class="tab-cell"> {{ $listeCompetences[$i]->code }} </td>
                      <td class="tab-cell" >{{ $listeCompetences[$i]->libelle }}</td>
                      <td class="tab-cell" >{{ $listeSemestres[$i]->libelle }}</td>
                      <td class="tab-cell" >{{ $listeSemestres[$i]->id_annee }}</td>
                      <form method="post" action = "{{route ('ue.destroy', ['ue'=>$tabUE[$i]->code]) }}">
                      @csrf
                      @method('DELETE')
                      <td><button class="tab-cell clear-cell del-button " type="submit">Supprimer </button></td>
                      </form>
                    </tr>
                    @endfor
                </tbody>
            </table>
          </div>
          </div>
        </div>
@endsection
