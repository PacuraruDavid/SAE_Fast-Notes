@php
  use App\Models\Eleve;
  use App\Models\Professeur;
  use App\Models\Admin;
@endphp
<header class="header" id="header">
    <nav class="nav container">
        <a href="{{ route('index') }}" class="nav_logo"
        >Fast Notes</a
        >
        <div class="nav_menu" id="nav-menu">
        <ul class="nav_list grid">
          @auth 
            @if (Admin::find(Auth::user()->code) != null) <li class="nav-items"> <a href="{{route('dashadmin')}}" class="nav_link">Dashboard Administrateur</a></li> @endif
            @if (Eleve::find(Auth::user()->code) != null) <li class="nav-items"> <a href="/visualisation/{{Auth::user()->code}}" class="nav_link">Visualisation des notes</a></li> @endif 
            @if (Professeur::find(Auth::user()->code) != null) <li class="nav-items"> <a href="{{ route('evaluations')}}" class="nav_link">Dashboard Professeur</a></li> @endif
          <li class="nav-items"><a class="nav_link" href="{{route('profil')}}">Profil</a></li>
          <li class="nav_item">
            <form method="POST" action="{{ route('logout') }}">
              @csrf
              <x-dropdown-link :href="route('logout')"
                  onclick="event.preventDefault();
                    this.closest('form').submit();">
                <p class="nav_link">{{ __('Se déconnecter') }}</p>
              </x-dropdown-link>
            </form>
          </li>
            @else
              <li class="nav_item">
              <a href="{{ route('login') }}" class="nav_link">
                  <i class="uil uil-message nav_icon"></i> Log in
              </a>
              </li>
            @endauth
        </ul>
        <i class="uil uil-times nav_close" id="nav-close"></i>
        </div>
        <div class="nav_btns">
        <i class="uil uil-moon change-theme" id="theme-button"></i>
        <div class="nav_toggle" id="nav-toggle">
            <i class="uil uil-apps"></i>
        </div>
        </div>
    </nav>
    </header>