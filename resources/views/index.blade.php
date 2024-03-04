@php 
  use App\Models\Admin;
  use App\Models\Professeur;
  use App\Models\Eleve;
  use App\Models\Parcours;
  use App\Models\Historique_Groupes;
  use App\Models\Groupe;
@endphp

<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />

    <!--  UNICONS  -->
    <link
    rel="stylesheet"
    href="https://unicons.iconscout.com/release/v4.0.0/css/line.css"
    />

    <!--  SWIPER CSS  -->
    <link rel="stylesheet" href="{{asset('assets/css/swiper-bundle.min.css')}}" />
    <!--  CSS  -->
    <link rel="stylesheet" href="{{asset('assets/css/styles.css')}}" />

    <title>Notes Iut</title>
</head>
<body>

    <!--  HEADER  -->
    @include ('partials.header')
    <!--  HEADER FIN  -->

    <!--  MAIN   -->
    <main class="main">
    <!-- HOME -->
    <section class="home section" id="home">
        <div class="home_container container grid">
          <div class="home_content-fix">
            @auth
              <h2 class="section_title">Bienvenue sur Fast Notes  </br>{{ Auth::user()->nom }} {{ Auth::user()->prenom }} </h2>
              @if(Admin::find(Auth::user()->code) != null)
              <a class="Entreprise button button-index" href="{{ route('dashadmin') }}"> Accéder à la dashboard Admin </a>
              @endif
              @if (Professeur::find(Auth::user()->code) != null)
              <a class="Entreprise button button-index" href="{{ route('evaluations') }}"> Accéder à la dashboard professeur </a>
              @endif
              @if (Eleve::find(Auth::user()->code) != null)
                <script>
                  function changerLink(){
                    let comboElement = document.getElementById("groupe_select");
                    let comboValue = comboElement.value;
                    let button_index = document.getElementById("visuNotes");
                    let base_link = button_index.href;
                    button_index.href = "/visualisation/{{Auth::user()->code}}?semestre=" + comboValue;
                  }


                  document.addEventListener('DOMContentLoaded', function() {
                    changerLink() })
                </script>
                @php 
                  $allGroupe = Historique_Groupes::all()->where('code_etudiant', Auth::user()->code);
                @endphp
                <select name="groupe_select" id="groupe_select" onchange="changerLink()">
                  <option value="{{Eleve::find(Auth::user()->code)->groupe->id }}">{{Eleve::find(Auth::user()->code)->groupe->parcour->semestre->libelle}}</option>
                  @foreach($allGroupe as $groupe_eleve)
                    @if(Eleve::find(Auth::user()->code)->groupe->parcour->semestre->libelle != Groupe::find($groupe_eleve->id_groupe)->parcour->semestre->libelle)
                      <option value="{{ Groupe::find($groupe_eleve->id_groupe)->id }}">{{ Groupe::find($groupe_eleve->id_groupe)->parcour->semestre->libelle }}</option>
                    @endif
                  @endforeach
                </select>
                <a id="visuNotes" class="Entreprise button button-index" href="/visualisation/{{Auth::user()->code}}?semestre="> Accéder à la visualisation des notes </a>
              @endif
            @else
            <form method="POST" action="{{ route('login') }}" class="form">
              @csrf
                <!-- Email Address -->
                <div class="flex_items email_flex">
                    <x-input-label for="code" class="label" :value="__('Identifiant')" />
                    <x-text-input id="code" class="form_input" type="text" name="code" :value="old('code')" required autofocus autocomplete="username" />
                    <x-input-error :messages="$errors->get('code')" class="mt-2" />
                </div>

                <!-- Password -->
                <div class="flex_items">
                    <x-input-label for="password" class="label" :value="__('Mot de passe')" />

                    <x-text-input id="password" class="form_input"
                                    type="password"
                                    name="password"
                                    required autocomplete="current-password" />

                    <x-input-error :messages="$errors->get('password')" class="mt-2" />
                </div>

                

                <div class="flex_items button-div">


                    <x-primary-button class="button button--flex log_btn">
                        {{ __('Se connecter') }}
                    </x-primary-button>
                </div>
            </form>
            @endauth
          </div>
        </div>
      </section>
      <!-- HOME FIN -->
    </main>
    <!-- MAIN FIN -->

    <!-- FOOTER -->
    <footer class="footer-index">
    <div class="footer_bg">
        <div class="footer_container container grid">
        <div>
            <h1 class="footer_title">Fast</h1>
            <span class="footer_subtitle">Notes</span>
        </div>

        <ul class="footer_links">
            <li>
            <a href="" class="footer_link">Qui sommes-nous ?</a>
            </li>
        </ul>
        </div>
        <p class="footer_copy">&#169; Code F. All rights reserved.</p>
    </div>
    </footer>
    <!-- FOOTER FIN -->

    <!-- SCROLL TOP  -->
    <a href="#" class="scrollup" id="scroll-up">
    <i class="uil uil-arrow-up scrollup_icon"></i>
    </a>
    <!-- SCROLL TOP FIN -->

    <!--  SWIPER JS  -->
    <script src="{{asset('assets/js/swiper-bundle.min.js')}}"></script>
    <!--  MAIN JS  -->
    <script src="{{asset('assets/js/main.js')}}"></script>
    <script src="{{ asset('js/app.js') }}"></script>
</body>
</html>
