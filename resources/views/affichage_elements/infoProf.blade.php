@extends('layouts.fn')

@section('title', 'Infos prof '.$utilisateur->nom)

@section('content')
<div class ="home_container container grid">
    <div class="home_content">
        <div>
        <h2> Informations sur {{$utilisateur->nom}} {{$utilisateur->prenom}} </h2>

        <h3> Code de connexion  : {{$utilisateur->code}}</h3>
        <h3> Adresse mél : {{$utilisateur->email}}</h3>
        </div>

        <h2> Enseignements </h2>

        <form method="post" action="{{ route('ajouterEnseignements') }}" class="add_form">
        @csrf
        <input type="hidden" name="professeur" value = "{{ $utilisateur->code }}">
        <table class="note-tab" id="enseign_table">
            <tr class="tab-row tab-row-dark">
                <th>Ressource</th>
                <th>Groupe</th>
                <th>Semestre</th>
                <th>Période</th>
            </tr>

        @foreach ($resListe as $enseignement )
            <tr clas="tab-row tab-row-clear">
                <td class="tab-cell">{{$enseignement["nomRessource"]}}</td>
                <td class="tab-cell centered-cell">{{$enseignement["groupe"]}}</td>
                <td class="tab-cell">{{$enseignement["semestre"]}}</td>
                <td class="tab-cell">{{$enseignement["periode"]}}</td>
            </tr>
        @endforeach
            <tr class="ligne_ajout">
                <td class="tab-cell">
                    <select>
                    @foreach ($listeRessources as $ressource)
                        <option value="{{$ressource->code}}">{{$ressource->libelle}}</option>
                    @endforeach
                    </select>
                </td>
                <td class="tab-cell centered-cell">  
                @php
                    function getLibelleSemestre ($groupe) {
                        return optional(optional($groupe->parcour)->semestre)->libelle ?? '(aucun semestre)';
                    }

                    function getIdAnnee ($groupe) {
                        return optional(optional($groupe->parcour)->semestre)->id_annee ?? ' - ';
                    }
                @endphp    
                
                    <select>
                    @foreach ($listeGroupes as $groupe)
                        <option value="{{$groupe->id}}">{{$groupe->libelle ." ". getLibelleSemestre($groupe)." ".getIdAnnee($groupe)}}</option>
                    @endforeach
                    </select></td>
                <td class="tab-cell groupe-cell"></td>
                <td class="tab-cell semestre-cell"></td>
                <td><button type="button" class="button del-button" onclick="removeRow(this)">Supprimer</button></td>
            </tr>
        </table>
        <button type="button" onclick="addRow()" class="button">Ajouter un enseignement</button>
            <button type="submit" class="button" disabled  id="valider">Confirmer les ajouts</button>
    </form>
    </div>
</div>

@endsection
<script>
    let rowCounter = 0;
    let compteur = 0;
    let boutonValider = null;
    document.addEventListener('DOMContentLoaded', function() {
        boutonValider = document.getElementById("valider");
        boutonValider.style.display = "none";



    })



    function addRow() {
        var tableau = document.getElementById("enseign_table");
        var ligne = document.querySelector(".ligne_ajout");
        boutonValider.removeAttribute("disabled");
        boutonValider.style.display = "inline-block";

        var nouvelle_ligne = ligne.cloneNode(true);
        var select = nouvelle_ligne.querySelectorAll("select");

        select[0].name = "ressource["+rowCounter+"]";
        select[1].name = "groupe["+rowCounter+"]";
        let cellGroupe = select[1].parentNode.nextElementSibling;
        let cellAnnees = cellGroupe.nextElementSibling;
        let selectedValue = select[1].options[0].innerHTML;
        let tabString = selectedValue.split(" ")
        cellGroupe.innerHTML = tabString[1]+" "+tabString[2];
        cellAnnees.innerHTML = tabString[3];

        
        select[1].addEventListener('change',function (event) {
            selectedValue = event.target.options[event.target.selectedIndex].innerHTML;
            console.log("Nouvelle valeur sélectionnée : " + selectedValue);
            tabString = selectedValue.split(" ")
            console.log(tabString);
            console.log(tabString[1]);
            cellGroupe.innerHTML = tabString[1]+" "+tabString[2];
            cellAnnees.innerHTML = tabString[3];


        })

        console.log(select.name);

        nouvelle_ligne.classList.remove("ligne_ajout");

        tableau.appendChild(nouvelle_ligne);

        rowCounter++;
        compteur++;
    }

    function removeRow(button) {
        const row = button.closest("tr");
        compteur--;
        if (compteur <=0) {
            boutonValider.style.display = "none"
        }
        row.remove();
    }


</script>