@extends('layouts.fn')

@section('title', 'Infos groupe '.$groupes->libelle)

@section('content')
<div class ="home_container container full_home">
    <div class="home_content full_home">
        <div class="text_center">
        <h2> Informations sur le groupe {{$groupes->libelle}}</h2>

        <h3> Identifiant du groupe : {{$groupes->id}}</h3>
        </div>
        <div class="items_admin flex_forms">
            <div class="flex_divs_tab">
                <h2 style="margin-top:10px;"> Elèves : </h2>
                <div class="scroll_div">
                    <table class="eleve-tab scroll_table">
                    <thead class="tab-row-dark">
                    <tr>   
                        <th>Code</th>
                        <th>Nom</th>
                        <th>Prenom</th>
                        <th></th>
                        <th></th>
                    </tr> 
                    </thead>
                    @for ($i = 0; $i < count($eleves); $i++)
                    <tr class="tab-row tab-row-clear">
                        <td class="tab-cell" >{{ $eleves[$i]->utilisateur->code}}</td>
                        <td class="tab-cell" >{{ $eleves[$i]->utilisateur->nom}}</td>
                        <td class="tab-cell" >{{ $eleves[$i]->utilisateur->prenom}}</td>
                        <td><a class="clear-cell button del-button " href="/supprimerEleveGroupe?id_eleve={{$eleves[$i]->utilisateur->code}}">Supprimer </a> </td>
                    </tr>
                    @endfor
                </table>
            </div>
                <form action="{{ route('addEleveGroupe') }}" class="" method="post">
                @csrf
                    <label for="eleves" class="info_eleve">Eleves</label>
                        <input type="hidden" name="groupe_id" value="{{$groupes->id}}"></input>
                        <select name="eleves" id="eleves" class="info_eleve">
                            @foreach($elevesNonGroupe as $eleve)
                                <option value="{{$eleve->code}}">
                                    @if ($eleve->id_groupe!=null) 
                                        {{ $eleve->id_groupe." ".$eleve->utilisateur->code." ". $eleve->utilisateur->nom." ". $eleve->utilisateur->prenom}}
                                    @else
                                        {{ $eleve->utilisateur->code." ". $eleve->utilisateur->nom." ". $eleve->utilisateur->prenom}}
                                    @endif
                                </option>
                            @endforeach
                        </select>
                        <input name="envoyer" type="submit" class="button" value="Ajouter l'élève"></input>
                    </form>
            </div>
            <div class="flex_divs_tab">
                <h2 style="margin-top:10px;"> Ressources : </h2>
                    <div class="scroll_div">
                    <table class="eleve-tab scroll_table">
                    <thead class="tab-row-dark">
                    <tr>   
                        <th>Code ressource</th>
                        <th>Libelle</th>
                        <th></th>
                    </tr> 
                    </thead>
                    @for ($i = 0; $i < count($ressources); $i++)
                    <tr class="tab-row tab-row-clear">
                        <td class="tab-cell" >{{ $ressources[$i]->code}}</td>
                        <td class="tab-cell" >{{ $ressources[$i]->libelle}}</td>
                        <td><a class="clear-cell button del-button " href="/supprimerRessourceGroupe?id_ressource={{$ressources[$i]->code}}&groupeId={{ $groupes->id }}">Supprimer </a> </td>
                    </tr>
                    @endfor
                </table>
                </div>
                <form action="{{ route('addRessourceGroupe') }}" class="" method="post">
                @csrf
                    <label for="eleves" class="info_eleve">Ressources :</label>
                        <input type="hidden" name="groupe_id" value="{{$groupes->id}}"></input>
                        <select name="ressource" id="ressource" class="info_eleve">
                            @foreach($ressourceNonGroupe as $ressource)
                                <option value="{{$ressource->code}}">
                                    {{ $ressource->code." ".$ressource->libelle}}
                                </option>
                            @endforeach
                        </select>
                        
                        <select name="prof" id="prof" class="info_eleve">
                            @foreach($profs as $prof)
                                <option value="{{$prof->utilisateur->code}}">
                                    {{ $prof->utilisateur->code." ".$prof->utilisateur->nom." ".$prof->utilisateur->prenom}}
                                </option>
                            @endforeach
                        </select>
                        <br>
                        <input name="envoyer" type="submit" class="button" value="Ajouter la ressource"></input>
                    </form>
            </div>
        </div>
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
        cellGroupe.innerHTML = tabString[1].split("(")[1]+" "+tabString[2];
        cellAnnees.innerHTML = tabString[3].split(")")[0];

        
        select[1].addEventListener('change',function (event) {
            selectedValue = event.target.options[event.target.selectedIndex].innerHTML;
            console.log("Nouvelle valeur sélectionnée : " + selectedValue);
            tabString = selectedValue.split(" ")
            console.log(tabString[1].split('('));
            cellGroupe.innerHTML = tabString[1].split("(")[1]+" "+tabString[2];
            cellAnnees.innerHTML = tabString[3].split(")")[0];


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