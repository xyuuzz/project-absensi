<div>
    @if ($paginator->hasPages())
            <ul class="pagination">
                {{-- Previous Page Link --}}
                @if ($paginator->onFirstPage())
                    <li class="page-item disabled" aria-disabled="true">
                        <span class="page-link">Mentok >></span>
                    </li>
                @else
                    <li class="page-item">
                        <button type="button" class="page-link" wire:click="previousPage" wire:loading.attr="disabled" rel="prev"><< Previous</button>
                    </li>
                @endif

                {{-- Next Page Link --}}
                @if ($paginator->hasMorePages())
                    <li class="page-item ml-3">
                        <button type="button" class="page-link" wire:click="nextPage" wire:loading.attr="disabled" rel="next">Next >></button>
                    </li>
                @else
                    <li class="page-item disabled ml-3" aria-disabled="true">
                        <span class="page-link"><< Mentok</span>
                    </li>
                @endif
            </ul>
    @endif
</div>
