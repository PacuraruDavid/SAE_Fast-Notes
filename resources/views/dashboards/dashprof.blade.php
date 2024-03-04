@extends('layouts.fn')

@section('title', 'Liste des évaluations')

@section('content')
        <div class="home_container container grid">
            <div class="home_content dashprof_content">
                <table class="eval_tab">
                    <thead class="tab-row-dark">
                        <tr>
                            <th>Nom</th>
                            <th>Type</th>
                            <th></th>
                            <th></th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($evals as $evaluation)
                        <tr >
                            <td class="tab-cell clear-cell">{{$evaluation -> libelle}}</td>
                            <td class="tab-cell clear-cell">{{ $evaluation -> type }}</td>
                            <td><button class="tab-cell clear-cell button button-modifier-note" onclick="window.location.href='/evaluation/{{$evaluation->id}}';" >Modifier les notes</button></td>
                            <td><button class="tab-cell clear-cell button button-modifier-note" onclick="window.location.href='/evaluation/{{$evaluation->id}}/stats';" >Voir les stats</button></td>
                        </tr>
                        
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
@endsection