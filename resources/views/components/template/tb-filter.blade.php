<div wire:ignore>
    <div class="row mb-3">
        <div class="col-sm-auto me-auto d-flex mb-2 btn-group-sm button_filter_grup div_btn_index_1 p-0">
            <div class="btn-group me-1 div_back_to_master"></div>
            @if ($accessSubMenu->iadd == 1)
                <div class="btn-group me-1">
                    <button wire:click="store()" type="button" id="btn_add_data" class="btn btn-primary rounded-1"
                        data-toggle="tooltip" data-placement="bottom" title="tambah data">
                        <i class="ti ti-plus"></i></button>
                </div>
            @endif
            <div class="btn-group me-1">
                <button type="button" class="btn btn-primary rounded-1 " data-bs-toggle="dropdown"
                    aria-expanded="false" data-toggle="tooltip" data-placement="bottom" title="Filter Status">
                    <i class="ti ti-filter"></i>
                </button>

                <input id="filterStatus" type="hidden" wire:model='filterStatus'>

                <ul class="dropdown-menu div_btn_index_filter_status">
                    @foreach ($tb_list_status as $data_status)
                        <li class="btn_tb_li_filter_status" data-id="{{ $data_status->id }}">
                            <button type="button" class="dropdown-item"
                                x-on:click="$wire.set('filterStatus', {{ $data_status->id }}), changeStyleFilterStatus({{ $data_status->id }})"
                                value="{{ $data_status->id }}">{{ $data_status->nama }}
                            </button>
                        </li>
                    @endforeach
                    <li>
                        <hr class="dropdown-divider">
                    </li>
                    <li class="btn_tb_li_filter_status" data-id="0">
                        <button type="button" class="dropdown-item"
                            x-on:click="$wire.set('filterStatus', ''), changeStyleFilterStatus(0)">Semua</button>
                    </li>
                </ul>
            </div>
            <div class="btn-group">
                <button type="button" id="btn_print_excel" class="btn btn-primary rounded-1" data-bs-toggle="dropdown"
                    wire:loading.attr='disabled' aria-expanded="false" data-toggle="tooltip" data-placement="bottom"
                    title="Export Data">
                    <span wire:loading.remove wire:target="export"><i class="ti ti-download"></i></span>
                    <span wire:loading wire:target="export">Loading..</span>
                </button>
                <ul class="dropdown-menu">
                    <li>
                        <button id="filterExportExcel" type="button" class="dropdown-item" wire:loading.attr='disabled'
                            wire:click="export('excel')">
                            <span wire:loading.remove wire:target="export('excel')">Excel</span>
                            <span wire:loading wire:target="export('excel')">Downloading...</span>
                        </button>
                        <button id="filterExportPdf" type="button" class="dropdown-item" wire:loading.attr='disabled'
                            wire:click="export('pdf')">
                            <span wire:loading.remove wire:target="export('pdf')">PDF</span>
                            <span wire:loading wire:target="export('pdf')">Downloading...</span>
                        </button>
                    </li>
                </ul>
            </div>
        </div>
        <div class=" col-md-4 div_btn_index_2 p-0">
            <input id="filterSearch" type="search" wire:model.live.debounce.500ms="filterSearch" class="form-control"
                placeholder="Cari Data....">
        </div>
    </div>
</div>
