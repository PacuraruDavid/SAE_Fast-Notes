@extends('layouts.fn')

@section('title', 'Mes notes')

@section('content')
        <div class="home_container container grid">
          <div class="home_content">
          @csrf
            <b class="semestre-m"> <p>Moyenne du semestre :</p>
            @if($moyenneSemestre < 10)
              <p style="color:red">
            @elseif($moyenneSemestre >= 10 && $moyenneSemestre < 15)
              <p style="color:orange">
            @else
              <p style="color:green">
            @endif
            @if ($moyenneSemestre !=="Pas disponible")
              {{ round($moyenneSemestre,2) }}
            @else
            {{ $moyenneSemestre }}
            @endif
            </p>
            </b>             
            <table class="table-moyenne" >
              @foreach ($tabMoyennesCompetences as $key => $valeur)
              
              <tr class="tab-row tab-row-dark">
                <td class="tab-cell"><b>{{ $key }}</b></td>
                @if ($valeur==="Pas disponible")
                  <td style="color:red" 
                @elseif($valeur < 10)
                <td style="color:red" 
                @elseif($valeur > 10 && $valeur < 15)
                <td style="color:orange" 
                @else
                <td style="color:green"
                @endif
                @if ($valeur =="Pas disponible")
                  class="tab-cell">{{ $valeur }}</td>
                @else
                  class="tab-cell">{{ round($valeur,2) }}</td>
                @endif
              </tr>
              @endforeach
            </table>

            <table class="note-tab">
                @foreach ($tabMoyennesRessources as $key => $valeur)
                  <tr class="tab-row tab-row-dark">
                    <td class="tab-cell" ><b>{{ $valeur[0] }}</b></td>
                    <td class="tab-cell"></td>
                    <td class="tab-cell centered-cell"> 
                      @if($valeur[1] == "Pas disponible") 
                        <p style="color:red">
                      @elseif($valeur[1] < 10)
                        <p style="color:red">
                      @elseif($valeur[1] >= 10 && $valeur[1] < 15) 
                        <p style="color:orange">
                      @else($valeur[1] >= 15) 
                        <p style="color:green">
                      @endif 
                      @if ($valeur[1] != "Pas disponible")
                      {{ round($valeur[1],2) }} 
                      @else 
                      {{ $valeur[1] }} </p>
                      @endif
                      </td>
                  </tr>
                    @foreach($tabNotes as $note )
                    @if ($note["code_ressource"] == $key)
                      <tr class="tab-row tab-row-clear">
                        <td class="tab-cell"> {{ $note["libelle"] }} </td>
                        <td class="tab-cell"> {{ $note["type"] }} </td>
                        
                          @if($note["note"] != "Pas disponible")
                            @if($note["note"] < 10)
                              <td style="color:red"  class="tab-cell centered-cell">{{ $note["note"] }}</td>
                            @endif
                            @if($note["note"] > 10 && $note["note"] < 15)
                              <td style="color:orange"  class="tab-cell centered-cell">{{ $note["note"] }}</td>
                            @endif
                            @if($note["note"] >= 15)
                              <td style="color:green" class="tab-cell centered-cell" >{{ $note["note"] }}</td>
                            @endif
                          @else
                            <td style="color:red"  class="tab-cell centered-cell">Pas disponible</td>
                          @endif
                        @endif
                        @endforeach
                      </tr>
                  
                @endforeach
            </table>
          </div>
        </div>
@endsection