@if($paginator->hasPages())
<nav aria-label="paginate">
    <ul class="pagination">
    @if($paginator->onFirstPage())
        <li class="page-item disabled">
            <a class="page-link" href="#" tabindex="-1" aria-disabled="true">Habis</a>
        </li>
    @else
        <li class="page-item">
            <a class="page-link" href="?page={{ count($_GET) ? $_GET["page"] - 1 : 1 }}" tabindex="-1" aria-disabled="true">Previous</a>
        </li>
    @endif

    @foreach($elements as $element)
        @if(is_array($element))
            @foreach($element as $page => $url)
                {{--
                    Jika ada var_g $_GET, maka pasangkan page dengan var_g get, jika tidak maka page == 1 
                --}}
                @if( count($_GET) ? $page == $_GET["page"] : $page == 1 )
                    <li class="page-item active">
                        <a class="page-link" href="?page={{ $page }}">{{ $page }}</a>
                    </li>
                @else
                    <li class="page-item">
                        <a class="page-link" href="?page={{ $page }}">{{ $page }}</a>
                    </li>
                @endif
            @endforeach
        @endif
        @endforeach

    @if($paginator->hasMorePages())
        <li class="page-item">
            <a class="page-link" href="?page={{ count($_GET) ? $_GET["page"] + 1 : 2 }}">Next</a>
        </li>
    @else
        <li class="page-item disabled">
            <a class="page-link" href="#">Habis</a>
        </li>
    @endif
</ul>
</nav>
@endif
