{{-- resources/views/vendor/pagination/simple-default.blade.php --}}
@if (!($paginator->onFirstPage() && !$paginator->hasMorePages()))
<ul class="pagination">
    {{-- Bouton de la page précédente --}}
    @if ($paginator->onFirstPage())
        <li class="disabled" aria-disabled="true" aria-label="@lang('pagination.previous')">
            <span aria-hidden="true">Page précédente</span>
        </li>
    @else
        <li >
            <a href="{{ $paginator->previousPageUrl() }}" rel="prev" class="page_button" aria-label="@lang('pagination.previous')">Page précédente</a>
        </li>
    @endif
    <li>|</li>

    {{-- Boutons de numérotation des pages --}}
    @foreach ($elements as $element)
        {{-- "Three Dots" Separator --}}
        @if (is_string($element))
            <li class="disabled" aria-disabled="true"><span>{{ $element }}</span></li>
        @endif

        {{-- Liens de page --}}
        @if (is_array($element))
            @foreach ($element as $page => $url)
                @if ($page == $paginator->currentPage())
                    <li class="active" aria-current="page"><span>{{ $page }}</span></li>
                @else
                    <li><a class="page_button" href="{{ $url }}">{{ $page }}</a></li>
                @endif
            @endforeach
        @endif
    @endforeach

    {{-- Bouton de la page suivante --}}
    <li>|</li>
    @if ($paginator->hasMorePages())
        <li>
            <a href="{{ $paginator->nextPageUrl() }}" rel="next" class="page_button" aria-label="@lang('pagination.next')">Page suivante</a>
        </li>
    @else
        <li class="disabled" aria-disabled="true" aria-label="@lang('pagination.next')">
            <span aria-hidden="true">Page suivante</span>
        </li>
    @endif
</ul>
@endif
