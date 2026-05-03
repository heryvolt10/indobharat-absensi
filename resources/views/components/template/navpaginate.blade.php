<div>
    @if ($paginator->hasPages())
        <nav role="navigation" aria-label="Pagination Navigation">
            <div class="row row-cols-auto justify-content-end">
                <div class="d-flex flex-wrap align-content-center">
                    <span class="fs-2">Page {{ $paginator->currentPage() }} - Total
                        {{ $paginator->total() }}</span>
                </div>
                <div>
                    <span>
                        @if ($paginator->onFirstPage())
                            <button class="btn btn-primary fs-2" disabled><i
                                    class="fa-solid fa-backward-step"></i></button>
                        @else
                            <button class="btn btn-primary fs-2" wire:click="previousPage" wire:loading.attr="disabled"
                                rel="prev"><i class="fa-solid fa-angle-left"></i></button>
                        @endif
                    </span>
                    <span>
                        @if ($paginator->onLastPage())
                            <button class="btn btn-primary fs-2" disabled><i
                                    class="fa-solid fa-forward-step"></i></button>
                        @else
                            <button class="btn btn-primary fs-2" wire:click="nextPage" wire:loading.attr="disabled"
                                rel="next"><i class="fa-solid fa-angle-right"></i></button>
                        @endif
                    </span>
                </div>
            </div>
        </nav>
    @endif
</div>
