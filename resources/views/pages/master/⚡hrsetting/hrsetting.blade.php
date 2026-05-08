<div>
    <div class="card">
        <div class="card-body">
            <!-- Nav tabs -->
            <ul class="nav nav-tabs" role="tablist" wire:ignore>
                <li class="nav-item">
                    <a class="nav-link {{ $activeTab === 'tab1' ? 'active' : '' }}" data-bs-toggle="tab" href="#tab1"
                        role="tab" wire:click="setTab('tab1')">
                        <span>Komponen Gaji</span>
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link {{ $activeTab === 'tab2' ? 'active' : '' }}" data-bs-toggle="tab" href="#tab2"
                        role="tab" wire:click="setTab('tab2')">
                        <span>PTKP</span>
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link {{ $activeTab === 'tab3' ? 'active' : '' }}" data-bs-toggle="tab" href="#tab3"
                        role="tab" wire:click="setTab('tab3')">
                        <span>Ter PTKP</span>
                    </a>
                </li>

                <li class="nav-item">
                    <a class="nav-link {{ $activeTab === 'tab4' ? 'active' : '' }}" data-bs-toggle="tab" href="#tab4"
                        role="tab" wire:click="setTab('tab4')">
                        <span>Periode</span>
                    </a>
                </li>
            </ul>
            <!-- Tab panes -->
            <div class="tab-content" wire:ignore.self>
                <div class="tab-pane mt-4 {{ $activeTab === 'tab1' ? 'active' : '' }}" id="tab1" role="tabpanel">
                </div>
                <div class="tab-pane mt-4 {{ $activeTab === 'tab2' ? 'active' : '' }}" id="tab2" role="tabpanel">
                    <div wire:show="showTable" wire:cloak>
                        <div class="p-3 mb-4">
                            @include('components.template.tb-filter')
                            <div class="row divtable">
                                <table id="tbindex_user" class="table tbview main-table table-hover ">
                                    <thead class="fw-medium">
                                        <tr>
                                            <th class="col-hide">id</th>
                                            <th width="1%">No</th>
                                            <th wire:click="sortBy('nama')" style="cursor: pointer;">Nama
                                                @if ($sortField === 'nama')
                                                    {{ $sortDir === 'ASC' ? '↑' : '↓' }}
                                                @endif
                                            </th>
                                            <th wire:click="sortBy('ter_grup')" style="cursor: pointer;">
                                                Ter Grup @if ($sortField === 'ter_grup')
                                                    {{ $sortDir === 'ASC' ? '↑' : '↓' }}
                                                @endif
                                            </th>
                                            <th class="print" wire:click="sortBy('ket')" style="cursor: pointer;">
                                                Keterangan @if ($sortField === 'ket')
                                                    {{ $sortDir === 'ASC' ? '↑' : '↓' }}
                                                @endif
                                            </th>
                                            <th width="5%">Status</th>
                                            <th class="last-col sticky-col" width="5%">#</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @if ($activeTab === 'tab2')
                                            @forelse ($data_rows as $li_data)
                                                <tr wire:key='{{ $li_data->id }}'>
                                                    <td class="col-hide">{{ $li_data->id }}</td>
                                                    <td>{{ ($data_rows->currentPage() - 1) * $data_rows->perPage() + $loop->index + 1 }}
                                                    </td>
                                                    <td>{{ $li_data->nama }}</td>
                                                    <td class="text-center">{{ $li_data->ter_grup }}</td>
                                                    <td>{{ $li_data->ket }}</td>
                                                    <td class="col-hide">{{ $li_data->f_status }}</td>
                                                    <td>{{ $li_data->status }}</td>
                                                    @include('components.template.tbview-button-1')
                                                </tr>
                                            @empty
                                                @include('components.template.no-data-table')
                                            @endforelse
                                        @endif

                                    </tbody>
                                </table>
                            </div>
                            @if ($activeTab === 'tab2')
                                @include('components.template.table-page')
                            @endif
                        </div>
                    </div>
                    <div wire:show="showForm" wire:cloak>
                        <form wire:submit="save" id="frmdata" class="frmform">
                            @csrf
                            <!-- ---------------------------------------------- button --------------------------------------------- -->
                            @include('components.template.trans-button-2')
                            <!-- ---------------------------------------------- button End --------------------------------------------- -->
                            <div class="row mb-3">
                                @if ($id_header)
                                    <span class="fw-bold fs-4">Edit Data</span>
                                @else
                                    <span class="fw-bold fs-4">Tambah Data</span>
                                @endif
                            </div>

                            <div class="row row-cols-1 row-cols-sm-2 row-cols-md-3">
                                <div class="mb-2">
                                    <label>Nama</label>
                                    <input wire:model="nama" id="nama" type="text"
                                        class="form-control @error('nama') is-invalid @enderror">
                                    @error('nama')
                                        <div class="spanerror">{{ $message }}</div>
                                    @enderror
                                </div>
                                <div class="mb-2 ">
                                    <label>Keterangan</label>
                                    <textarea wire:model="ket" id="ket" type="text" class="form-control @error('ket') is-invalid @enderror"></textarea>
                                    @error('ket')
                                        <div class="spanerror">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                            <div class="row row-cols-1 row-cols-sm-2 row-cols-md-3">
                                <div class="mb-2">
                                    <label>Status</label>
                                    <div class="input-group">
                                        <input wire:model="f_status_tag" id="f_status_tag" type="text"
                                            onchange="@this.set('f_status_tag', this.value);"
                                            class="form-control onlyread @error('f_status') is-invalid @enderror"
                                            readonly>
                                        <input wire:model="f_status" id="f_status" name="f_status" type="text"
                                            onchange="@this.set('f_status', this.value);" class="form-control" hidden>
                                        <button class="btn btn-success listdata" type="button" data-idinput="f_status"
                                            data-poptitle="Status" data-tblist="list_status" data-type="0"><i
                                                class="ti ti-search"></i></button>
                                    </div>
                                    @error('f_status')
                                        <div class="spanerror">{{ $message }}</div>
                                    @enderror
                                </div>
                                <div class="mb-2 divOrg">
                                    <label>Org</label>
                                    <div class="input-group">
                                        <input wire:model="f_org_tag" id="f_org_tag" type="text"
                                            onchange="@this.set('f_org_tag', this.value);"
                                            class="form-control onlyread @error('f_org') is-invalid @enderror"
                                            readonly>
                                        <input wire:model="f_org" id="f_org" type="text" class="form-control"
                                            onchange="@this.set('f_org', this.value);" hidden>
                                        <button class="btn btn-success listdata" type="button" data-idinput="f_org"
                                            data-poptitle="Org" data-tblist="list_org" data-type="0"><i
                                                class="ti ti-search"></i></button>
                                    </div>
                                    @error('f_org')
                                        <div class="spanerror">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
                <div class="tab-pane mt-4 {{ $activeTab === 'tab3' ? 'show active' : '' }}" id="tab3"
                    role="tabpanel">
                    <div wire:show="showTable" wire:cloak>
                        <div class="p-3 mb-4">
                            @include('components.template.tb-filter')
                            <div class="row divtable">
                                <table id="tbindex_user" class="table tbview main-table table-hover ">
                                    <thead class="fw-medium">
                                        <tr>
                                            <th class="col-hide">id</th>
                                            <th width="1%">No</th>
                                            <th wire:click="sortBy('grup')" style="cursor: pointer;">
                                                Grup
                                                @if ($sortField === 'grup')
                                                    {{ $sortDir === 'ASC' ? '↑' : '↓' }}
                                                @endif
                                            </th>
                                            <th wire:click="sortBy('nilai')" style="cursor: pointer;">Nilai
                                                @if ($sortField === 'nilai')
                                                    {{ $sortDir === 'ASC' ? '↑' : '↓' }}
                                                @endif
                                            </th>
                                            <th class="print" wire:click="sortBy('persen')"
                                                style="cursor: pointer;">
                                                Persen
                                                @if ($sortField === 'persen')
                                                    {{ $sortDir === 'ASC' ? '↑' : '↓' }}
                                                @endif
                                            </th>
                                            <th width="5%">Status</th>
                                            <th class="last-col sticky-col" width="5%">#</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @if ($activeTab === 'tab3')
                                            @forelse ($data_rows as $li_data)
                                                <tr wire:key='{{ $li_data->id }}'>
                                                    <td class="col-hide">{{ $li_data->id }}</td>
                                                    <td>{{ ($data_rows->currentPage() - 1) * $data_rows->perPage() + $loop->index + 1 }}
                                                    </td>
                                                    <td class="text-center">{{ $li_data->grup }}</td>
                                                    <td class="text-end">{{ $li_data->nilai }}</td>
                                                    <td>{{ $li_data->persen }}</td>
                                                    <td class="col-hide">{{ $li_data->f_status }}</td>
                                                    <td>{{ $li_data->status }}</td>
                                                    @include('components.template.tbview-button-1')
                                                </tr>
                                            @empty
                                                @include('components.template.no-data-table')
                                            @endforelse
                                        @endif
                                    </tbody>
                                </table>
                            </div>
                            @if ($activeTab === 'tab3')
                                @include('components.template.table-page')
                            @endif
                        </div>
                    </div>
                    <div wire:show="showForm" wire:cloak>
                        <form wire:submit="save" id="frmdata" class="frmform">
                            @csrf
                            <!-- ---------------------------------------------- button --------------------------------------------- -->
                            @include('components.template.trans-button-2')
                            <!-- ---------------------------------------------- button End --------------------------------------------- -->
                            <div class="row mb-3">
                                @if ($id_header)
                                    <span class="fw-bold fs-4">Edit Data</span>
                                @else
                                    <span class="fw-bold fs-4">Tambah Data</span>
                                @endif
                            </div>

                            <div class="row row-cols-1 row-cols-sm-2 row-cols-md-3">
                                <div class="mb-2">
                                    <label>Grup</label>
                                    <input wire:model="grup" id="grup" type="text"
                                        class="form-control @error('grup') is-invalid @enderror">
                                    @error('grup')
                                        <div class="spanerror">{{ $message }}</div>
                                    @enderror
                                </div>
                                <div class="mb-2">
                                    <label>Nilai</label>
                                    <input wire:model="nilai" id="nilai" type="text"
                                        class="form-control @error('nilai') is-invalid @enderror">
                                    @error('nilai')
                                        <div class="spanerror">{{ $message }}</div>
                                    @enderror
                                </div>
                                <div class="mb-2">
                                    <label>Persen</label>
                                    <input wire:model="persen" id="persen" type="text"
                                        class="form-control @error('persen') is-invalid @enderror">
                                    @error('persen')
                                        <div class="spanerror">{{ $message }}</div>
                                    @enderror
                                </div>

                            </div>
                            <div class="row row-cols-1 row-cols-sm-2 row-cols-md-3">
                                <div class="mb-2">
                                    <label>Status</label>
                                    <div class="input-group">
                                        <input wire:model="f_status_tag" id="f_status_tag" type="text"
                                            onchange="@this.set('f_status_tag', this.value);"
                                            class="form-control onlyread @error('f_status') is-invalid @enderror"
                                            readonly>
                                        <input wire:model="f_status" id="f_status" name="f_status" type="text"
                                            onchange="@this.set('f_status', this.value);" class="form-control" hidden>
                                        <button class="btn btn-success listdata" type="button"
                                            data-idinput="f_status" data-poptitle="Status" data-tblist="list_status"
                                            data-type="0"><i class="ti ti-search"></i></button>
                                    </div>
                                    @error('f_status')
                                        <div class="spanerror">{{ $message }}</div>
                                    @enderror
                                </div>
                                <div class="mb-2 divOrg">
                                    <label>Org</label>
                                    <div class="input-group">
                                        <input wire:model="f_org_tag" id="f_org_tag" type="text"
                                            onchange="@this.set('f_org_tag', this.value);"
                                            class="form-control onlyread @error('f_org') is-invalid @enderror"
                                            readonly>
                                        <input wire:model="f_org" id="f_org" type="text" class="form-control"
                                            onchange="@this.set('f_org', this.value);" hidden>
                                        <button class="btn btn-success listdata" type="button" data-idinput="f_org"
                                            data-poptitle="Org" data-tblist="list_org" data-type="0"><i
                                                class="ti ti-search"></i></button>
                                    </div>
                                    @error('f_org')
                                        <div class="spanerror">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
                <div class="tab-pane mt-4 {{ $activeTab === 'tab4' ? 'show active' : '' }} " id="tab4"
                    role="tabpanel">
                    <div wire:show="showTable" wire:cloak>
                        <div class="p-3 mb-4">
                            @include('components.template.tb-filter')
                            <div class="row divtable">
                                <table id="tbindex_user" class="table tbview main-table table-hover ">
                                    <thead class="fw-medium">
                                        <tr>
                                            <th class="col-hide">id</th>
                                            <th width="1%">No</th>
                                            <th wire:click="sortBy('tanggal')" style="cursor: pointer;">
                                                Tanggal
                                                @if ($sortField === 'tanggal')
                                                    {{ $sortDir === 'ASC' ? '↑' : '↓' }}
                                                @endif
                                            </th>
                                            <th wire:click="sortBy('tanggal_mulai')" style="cursor: pointer;">
                                                Mulai
                                                @if ($sortField === 'tanggal_mulai')
                                                    {{ $sortDir === 'ASC' ? '↑' : '↓' }}
                                                @endif
                                            </th>
                                            <th width="5%">Status</th>
                                            <th class="last-col sticky-col" width="5%">#</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @if ($activeTab === 'tab4')
                                            @forelse ($data_rows as $li_data)
                                                <tr wire:key='{{ $li_data->id }}'>
                                                    <td class="col-hide">{{ $li_data->id }}</td>
                                                    <td>{{ ($data_rows->currentPage() - 1) * $data_rows->perPage() + $loop->index + 1 }}
                                                    </td>
                                                    <td class="text-center">{{ $li_data->tanggal }}</td>
                                                    <td class="text-end">{{ $li_data->tanggal_mulai }}</td>
                                                    <td class="col-hide">{{ $li_data->f_status }}</td>
                                                    <td>{{ $li_data->status }}</td>
                                                    @include('components.template.tbview-button-1')
                                                </tr>
                                            @empty
                                                @include('components.template.no-data-table')
                                            @endforelse
                                        @endif
                                    </tbody>
                                </table>
                            </div>
                            @if ($activeTab === 'tab4')
                                @include('components.template.table-page')
                            @endif
                        </div>
                    </div>
                    <div wire:show="showForm" wire:cloak>
                        <form wire:submit="save" id="frmdata" class="frmform">
                            @csrf
                            <!-- ---------------------------------------------- button --------------------------------------------- -->
                            @include('components.template.trans-button-2')
                            <!-- ---------------------------------------------- button End --------------------------------------------- -->
                            <div class="row mb-3">
                                @if ($id_header)
                                    <span class="fw-bold fs-4">Edit Data</span>
                                @else
                                    <span class="fw-bold fs-4">Tambah Data</span>
                                @endif
                            </div>

                            <div class="row row-cols-1 row-cols-sm-2 row-cols-md-3">
                                <div class="mb-2">
                                    <label>Tanggal Aktif</label>
                                    <input wire:model="tanggal" id="tanggal" type="text"
                                        onchange="@this.set('tanggal', this.value);"
                                        class="form-control dDate @error('tanggal') is-invalid @enderror" readonly>
                                    @error('tanggal')
                                        <div class="spanerror">{{ $message }}</div>
                                    @enderror
                                </div>
                                <div class="mb-2">
                                    <label>Mulai</label>
                                    <input wire:model="tanggal_mulai" id="tanggal_mulai" type="text"
                                        onchange="@this.set('tanggal_mulai', this.value);"
                                        class="form-control mask_day text-end @error('tanggal_mulai') is-invalid @enderror">
                                    @error('tanggal_mulai')
                                        <div class="spanerror">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                            <div class="row row-cols-1 row-cols-sm-2 row-cols-md-3">
                                <div class="mb-2">
                                    <label>Status</label>
                                    <div class="input-group">
                                        <input wire:model="f_status_tag" id="f_status_tag" type="text"
                                            onchange="@this.set('f_status_tag', this.value);"
                                            class="form-control onlyread @error('f_status') is-invalid @enderror"
                                            readonly>
                                        <input wire:model="f_status" id="f_status" name="f_status" type="text"
                                            onchange="@this.set('f_status', this.value);" class="form-control" hidden>
                                        <button class="btn btn-success listdata" type="button"
                                            data-idinput="f_status" data-poptitle="Status" data-tblist="list_status"
                                            data-type="0"><i class="ti ti-search"></i></button>
                                    </div>
                                    @error('f_status')
                                        <div class="spanerror">{{ $message }}</div>
                                    @enderror
                                </div>
                                <div class="mb-2 divOrg">
                                    <label>Org</label>
                                    <div class="input-group">
                                        <input wire:model="f_org_tag" id="f_org_tag" type="text"
                                            onchange="@this.set('f_org_tag', this.value);"
                                            class="form-control onlyread @error('f_org') is-invalid @enderror"
                                            readonly>
                                        <input wire:model="f_org" id="f_org" type="text" class="form-control"
                                            onchange="@this.set('f_org', this.value);" hidden>
                                        <button class="btn btn-success listdata" type="button" data-idinput="f_org"
                                            data-poptitle="Org" data-tblist="list_org" data-type="0"><i
                                                class="ti ti-search"></i></button>
                                    </div>
                                    @error('f_org')
                                        <div class="spanerror">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>

        </div>
    </div>
</div>

@include('components.template.delete-table')

<script>
    // ============================= POPUP MODAL LIST =============================
    $(document).on('click', ".listdata", function(e) {
        $list_tbilst = $(this).data('tblist');

        if ($list_tbilst == 'list_status') {
            $("#listmodal_custom1").val("1").change();
        }
    });

    // ============================= POPUP MODAL LIST END =============================
</script>
