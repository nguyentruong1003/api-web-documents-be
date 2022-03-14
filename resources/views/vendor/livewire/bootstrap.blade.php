<div class="col-md-6">
    @if ($paginator->hasPages())
    <ul class="pagination float-right mt-3 mb-2">
        {{-- Previous Page Link --}}
        @if ($paginator->onFirstPage())
        <li class="page-item disabled" aria-disabled="true" aria-label="@lang('pagination.previous')">
            <a class="prev" aria-hidden="true">&lsaquo;</a>
        </li>
        @else
        <li>
            <span style="cursor: pointer" class="prev active" wire:click="previousPage" wire:loading.attr="disabled" rel="prev" aria-label="@lang('pagination.previous')" href="javascript:void(0)">
            &lsaquo;
        </a>
        </li>
        @endif

        {{-- Pagination Elements --}}
        @foreach ($elements as $element)
        {{-- "Three Dots" Separator --}}
        @if (is_string($element))
        <li class="page-item disabled" aria-disabled="true"><span class="page-link">{{ $element }}</span></li>
        @endif

        {{-- Array Of Links --}}
        @if (is_array($element))
        @foreach ($element as $page => $url)
        @if ($page == $paginator->currentPage())
        <li wire:key="paginator-page-{{ $page }}" aria-current="page"><a style="padding:3px 16px; color:gray " class="text-primary">{{ $page }}</a></li>
        @else
        <!--                            <li class="page-item" wire:key="paginator-page-{{ $page }}"><button type="button" class="page-link" wire:click="gotoPage({{ $page }})" >{{ $page }}</button>
                                </li> -->

        <li wire:key="paginator-page-{{ $page }}">
            <a style="padding: 3px 16px; color: gray;" wire:click="gotoPage({{ $page }})" href="javascript:void(0)">
                {{ $page }}
            </a>
        </li>


        @endif
        @endforeach
        @endif
        @endforeach

        {{-- Next Page Link --}}
        @if ($paginator->hasMorePages())
        <li>
            <a class="next active" wire:click="nextPage" wire:loading.attr="disabled" aria-label="@lang('pagination.next')" href="javascript:void(0)">&rsaquo;</a>
        </li>
        @else
        <li aria-disabled="true" aria-label="@lang('pagination.next')">
            <a class="prev">&rsaquo;</a>
        </li>
        @endif
    </ul>
    @endif
</div>