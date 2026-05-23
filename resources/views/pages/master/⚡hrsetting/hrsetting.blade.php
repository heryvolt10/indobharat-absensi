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
                <li class="nav-item">
                    <a class="nav-link {{ $activeTab === 'tab5' ? 'active' : '' }}" data-bs-toggle="tab" href="#tab5"
                        role="tab" wire:click="setTab('tab5')">
                        <span>Tunjangan</span>
                    </a>
                </li>
            </ul>
            <!-- Tab panes -->
            <div class="tab-content" wire:ignore.self>
                <div class="tab-pane mt-4 {{ $activeTab === 'tab1' ? 'active' : '' }}" id="tab1" role="tabpanel">
                    <div wire:show="showTable" wire:cloak>
                        <div class="p-3 mb-4">
                            @include('components.template.tb-filter', [
                                'no_button_add' => '1',
                                'no_button_status' => '1',
                                'no_button_export' => '1',
                            ])
                            <div class="row divtable">
                                <table id="tbindex_user" class="table tbview main-table table-hover ">
                                    <thead class="fw-medium">
                                        <tr>
                                            <th class="col-hide">id</th>
                                            <th width="1%">No</th>
                                            <th wire:click="sortBy('kode')" style="cursor: pointer;">Kode
                                                @if ($sortField === 'kode')
                                                    {{ $sortDir === 'ASC' ? '↑' : '↓' }}
                                                @endif
                                            </th>
                                            <th wire:click="sortBy('pay_tipe')" style="cursor: pointer;">
                                                Tipe @if ($sortField === 'pay_tipe')
                                                    {{ $sortDir === 'ASC' ? '↑' : '↓' }}
                                                @endif
                                            </th>
                                            <th wire:click="sortBy('pay_grup')" style="cursor: pointer;">
                                                Grup @if ($sortField === 'pay_grup')
                                                    {{ $sortDir === 'ASC' ? '↑' : '↓' }}
                                                @endif
                                            </th>
                                            <th wire:click="sortBy('pay_set')" style="cursor: pointer;">
                                                Setting @if ($sortField === 'pay_set')
                                                    {{ $sortDir === 'ASC' ? '↑' : '↓' }}
                                                @endif
                                            </th>
                                            <th wire:click="sortBy('pay_tax')" style="cursor: pointer;">
                                                Tax @if ($sortField === 'pay_tax')
                                                    {{ $sortDir === 'ASC' ? '↑' : '↓' }}
                                                @endif
                                            </th>
                                            <th wire:click="sortBy('nilai')" style="cursor: pointer;">
                                                Nilai @if ($sortField === 'nilai')
                                                    {{ $sortDir === 'ASC' ? '↑' : '↓' }}
                                                @endif
                                            </th>
                                            <th wire:click="sortBy('ket_rumusan')" style="cursor: pointer;">
                                                Rumusan @if ($sortField === 'ket_rumusan')
                                                    {{ $sortDir === 'ASC' ? '↑' : '↓' }}
                                                @endif
                                            </th>
                                            <th wire:click="sortBy('ket')" style="cursor: pointer;">
                                                Keterangan @if ($sortField === 'ket')
                                                    {{ $sortDir === 'ASC' ? '↑' : '↓' }}
                                                @endif
                                            </th>
                                            <th wire:click="sortBy('ket2')" style="cursor: pointer;">
                                                Keterangan 2 @if ($sortField === 'ket2')
                                                    {{ $sortDir === 'ASC' ? '↑' : '↓' }}
                                                @endif
                                            </th>
                                            <th wire:click="sortBy('ket3')" style="cursor: pointer;">
                                                Keterangan 3 @if ($sortField === 'ket3')
                                                    {{ $sortDir === 'ASC' ? '↑' : '↓' }}
                                                @endif
                                            </th>
                                            <th class="last-col sticky-col" width="5%">#</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @if ($activeTab === 'tab1')
                                            @forelse ($data_rows as $li_data)
                                                <tr wire:key='{{ $li_data->id }}'>
                                                    <td class="col-hide">{{ $li_data->id }}</td>
                                                    <td>{{ ($data_rows->currentPage() - 1) * $data_rows->perPage() + $loop->index + 1 }}
                                                    </td>
                                                    <td>{{ $li_data->kode }}</td>
                                                    <td>{{ $li_data->pay_tipe }}</td>
                                                    <td>{{ $li_data->pay_grup }}</td>
                                                    <td>{{ $li_data->pay_set }}</td>
                                                    <td>{{ $li_data->pay_tax }}</td>
                                                    <td text-end>{{ help_format_money($li_data->nilai) }}</td>
                                                    <td>{{ $li_data->ket_rumusan }}</td>
                                                    <td>{{ $li_data->ket }}</td>
                                                    <td>{{ $li_data->ket2 }}</td>
                                                    <td>{{ $li_data->ket3 }}</td>
                                                    @include('components.template.tbview-button', [
                                                        'no_tbview_delete' => '1',
                                                    ])
                                                </tr>
                                            @empty
                                                @include('components.template.no-data-table')
                                            @endforelse
                                        @endif
                                    </tbody>
                                </table>
                            </div>
                            @if ($activeTab === 'tab1')
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
                                    <label>Kode</label>
                                    <input wire:model="kode" id="kode" type="text"
                                        class="form-control @error('kode') is-invalid @enderror">
                                    @error('kode')
                                        <div class="spanerror">{{ $message }}</div>
                                    @enderror
                                </div>
                                <div class="mb-2">
                                    <label>Tipe</label>
                                    <input wire:model="pay_tipe" id="pay_tipe" type="text"
                                        class="form-control @error('pay_tipe') is-invalid @enderror">
                                    @error('pay_tipe')
                                        <div class="spanerror">{{ $message }}</div>
                                    @enderror
                                </div>
                                <div class="mb-2">
                                    <label>Grup</label>
                                    <input wire:model="pay_grup" id="pay_grup" type="text"
                                        class="form-control @error('pay_grup') is-invalid @enderror">
                                    @error('pay_grup')
                                        <div class="spanerror">{{ $message }}</div>
                                    @enderror
                                </div>
                                <div class="mb-2">
                                    <label>Setting</label>
                                    <input wire:model="pay_set" id="pay_set" type="text"
                                        class="form-control @error('pay_set') is-invalid @enderror">
                                    @error('pay_set')
                                        <div class="spanerror">{{ $message }}</div>
                                    @enderror
                                </div>
                                <div class="mb-2">
                                    <label>Tax</label>
                                    <input wire:model="pay_tax" id="pay_tax" type="text"
                                        class="form-control @error('pay_tax') is-invalid @enderror">
                                    @error('pay_tax')
                                        <div class="spanerror">{{ $message }}</div>
                                    @enderror
                                </div>
                                <div class="mb-2">
                                    <label>Nilai</label>
                                    <input wire:model="nilai" id="nilai" type="text"
                                        class="form-control mask_decimal text-end @error('nilai') is-invalid @enderror"
                                        onchange="@this.set('nilai', this.value);" value="0">
                                    @error('nilai')
                                        <div class="spanerror">{{ $message }}</div>
                                    @enderror
                                </div>
                                <div class="mb-2 ">
                                    <label>Rumusan</label>
                                    <textarea wire:model="ket_rumusan" id="ket_rumusan" type="text"
                                        class="form-control @error('ket_rumusan') is-invalid @enderror"></textarea>
                                    @error('ket_rumusan')
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
                                <div class="mb-2 ">
                                    <label>Keterangan 2</label>
                                    <textarea wire:model="ket2" id="ket2" type="text" class="form-control @error('ket2') is-invalid @enderror"></textarea>
                                    @error('ket2')
                                        <div class="spanerror">{{ $message }}</div>
                                    @enderror
                                </div>
                                <div class="mb-2 ">
                                    <label>Keterangan 3</label>
                                    <textarea wire:model="ket3" id="ket3" type="text" class="form-control @error('ket3') is-invalid @enderror"></textarea>
                                    @error('ket3')
                                        <div class="spanerror">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>

                        </form>
                    </div>
                </div>
                <div class="tab-pane mt-4 {{ $activeTab === 'tab2' ? 'active' : '' }}" id="tab2"
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
                                            <th wire:click="sortBy('nilai')" style="cursor: pointer;">
                                                Nilai @if ($sortField === 'nilai')
                                                    {{ $sortDir === 'ASC' ? '↑' : '↓' }}
                                                @endif
                                            </th>
                                            <th wire:click="sortBy('ket')" style="cursor: pointer;">
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
                                                    <td class="text-end">{{ help_format_money($li_data->nilai) }}</td>
                                                    <td>{{ $li_data->ket }}</td>
                                                    <td class="col-hide">{{ $li_data->f_status }}</td>
                                                    <td>{{ $li_data->status }}</td>
                                                    @include('components.template.tbview-button')
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
                                            <th wire:click="sortBy('persen')" style="cursor: pointer;">
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
                                                    <td class="text-end">{{ help_format_money($li_data->nilai) }}</td>
                                                    <td class="text-end">{{ help_format_money($li_data->persen) }}
                                                    </td>
                                                    <td class="col-hide">{{ $li_data->f_status }}</td>
                                                    <td>{{ $li_data->status }}</td>
                                                    @include('components.template.tbview-button')
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
                                        class="form-control mask_decimal @error('nilai') is-invalid @enderror"
                                        onchange="@this.set('nilai', this.value);" value="0">
                                    @error('nilai')
                                        <div class="spanerror">{{ $message }}</div>
                                    @enderror
                                </div>
                                <div class="mb-2">
                                    <label>Persen</label>
                                    <input wire:model="persen" id="persen" type="text"
                                        class="form-control mask_decimal @error('persen') is-invalid @enderror"
                                        onchange="@this.set('persen', this.value);" value="0">
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
                                                    <td class="text-center">{{ $li_data->tanggal_mulai }}</td>
                                                    <td class="col-hide">{{ $li_data->f_status }}</td>
                                                    <td>{{ $li_data->status }}</td>
                                                    @include('components.template.tbview-button')
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

                <div class="tab-pane mt-4 {{ $activeTab === 'tab5' ? 'active' : '' }}" id="tab5"
                    role="tabpanel">
                    <div wire:show="showTable" wire:cloak>
                        <div class="p-3 mb-4">
                            @include('components.template.tb-filter', [
                                'no_button_add' => '1',
                                'no_button_status' => '1',
                            ])
                            <div class="row divtable">
                                @php
                                    $tunjanganHeaderPendapatan = [];
                                    $tunjanganHeaderPengurangan = [];

                                    if ($activeTab === 'tab5' && $data_rows->count()) {
                                        $firstTunjangan = json_decode($data_rows->first()->tunjangan, true);
                                        if (is_array($firstTunjangan)) {
                                            if (
                                                !empty($firstTunjangan['pendapatan']) &&
                                                is_array($firstTunjangan['pendapatan'])
                                            ) {
                                                $tunjanganHeaderPendapatan = array_keys($firstTunjangan['pendapatan']);
                                            }
                                            if (
                                                !empty($firstTunjangan['pengurangan']) &&
                                                is_array($firstTunjangan['pengurangan'])
                                            ) {
                                                $tunjanganHeaderPengurangan = array_keys(
                                                    $firstTunjangan['pengurangan'],
                                                );
                                            }
                                        }
                                    }
                                @endphp
                                <table id="tbindex_user" class="table tbview main-table table-hover ">
                                    <thead class="fw-medium">
                                        <tr>
                                            <th class="col-hide">id</th>
                                            <th width="1%">No</th>
                                            <th wire:click="sortBy('NIK')" style="cursor: pointer;">NIK
                                                @if ($sortField === 'NIK')
                                                    {{ $sortDir === 'ASC' ? '↑' : '↓' }}
                                                @endif
                                            </th>
                                            <th wire:click="sortBy('nama')" style="cursor: pointer;">Nama
                                                @if ($sortField === 'nama')
                                                    {{ $sortDir === 'ASC' ? '↑' : '↓' }}
                                                @endif
                                            </th>
                                            @foreach ($tunjanganHeaderPendapatan as $header)
                                                <th>{{ ucwords(str_replace('_', ' ', $header)) }}</th>
                                            @endforeach
                                            @foreach ($tunjanganHeaderPengurangan as $header)
                                                <th>{{ ucwords(str_replace('_', ' ', $header)) }}</th>
                                            @endforeach
                                            <th class="last-col sticky-col" width="5%">#</th>
                                        </tr>

                                    </thead>
                                    <tbody>
                                        @if ($activeTab === 'tab5')
                                            @forelse ($data_rows as $li_data)
                                                @php
                                                    $decodedTunjangan = json_decode($li_data->tunjangan, true);
                                                    $pendapatan = is_array($decodedTunjangan['pendapatan'] ?? null)
                                                        ? $decodedTunjangan['pendapatan']
                                                        : [];
                                                    $pengurangan = is_array($decodedTunjangan['pengurangan'] ?? null)
                                                        ? $decodedTunjangan['pengurangan']
                                                        : [];
                                                @endphp
                                                <tr wire:key='{{ $li_data->id }}'>
                                                    <td class="col-hide">{{ $li_data->id }}</td>
                                                    <td>{{ ($data_rows->currentPage() - 1) * $data_rows->perPage() + $loop->index + 1 }}
                                                    </td>
                                                    <td>{{ $li_data->NIK }}</td>
                                                    <td>{{ $li_data->nama }}</td>
                                                    @foreach ($tunjanganHeaderPendapatan as $key)
                                                        <td class="text-end">
                                                            {{ isset($pendapatan[$key]) ? help_format_money($pendapatan[$key]) : '-' }}
                                                        </td>
                                                    @endforeach
                                                    @foreach ($tunjanganHeaderPengurangan as $key)
                                                        <td class="text-end">
                                                            {{ isset($pengurangan[$key]) ? help_format_money($pengurangan[$key]) : '-' }}
                                                        </td>
                                                    @endforeach
                                                    @include('components.template.tbview-button', [
                                                        'no_tbview_delete' => '1',
                                                    ])
                                                </tr>
                                            @empty
                                                @include('components.template.no-data-table')
                                            @endforelse
                                        @endif

                                    </tbody>
                                </table>
                            </div>
                            @if ($activeTab === 'tab5')
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
                                    <label>NIK</label>
                                    <input wire:model="NIK" id="NIK" type="text"
                                        class="form-control onlyread @error('NIK') is-invalid @enderror" readonly>
                                    @error('NIK')
                                        <div class="spanerror">{{ $message }}</div>
                                    @enderror
                                </div>
                                <div class="mb-2">
                                    <label>Nama</label>
                                    <input wire:model="nama" id="nama" type="text"
                                        class="form-control onlyread @error('nama') is-invalid @enderror" readonly>
                                    @error('nama')
                                        <div class="spanerror">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                            <div class="row row-cols-1 row-cols-sm-2 row-cols-md-3">
                                <div class="mb-2">
                                    <label>Gaji Pokok</label>
                                    <input wire:model="tunjangan_gaji_pokok" id="tunjangan_gaji_pokok" type="text"
                                        class="form-control mask_decimal text-end @error('tunjangan_gaji_pokok') is-invalid @enderror"
                                        onchange="@this.set('tunjangan_gaji_pokok', this.value);" value="0">
                                    @error('tunjangan_gaji_pokok')
                                        <div class="spanerror">{{ $message }}</div>
                                    @enderror
                                </div>
                                <div class="mb-2">
                                    <label>Inf Jabatan</label>
                                    <input wire:model="tunjangan_inf_jabatan" id="tunjangan_inf_jabatan"
                                        type="text"
                                        class="form-control mask_decimal text-end @error('tunjangan_inf_jabatan') is-invalid @enderror"
                                        onchange="@this.set('tunjangan_inf_jabatan', this.value);" value="0">
                                    @error('tunjangan_inf_jabatan')
                                        <div class="spanerror">{{ $message }}</div>
                                    @enderror
                                </div>
                                <div class="mb-2">
                                    <label>Inf Transport</label>
                                    <input wire:model="tunjangan_inf_transport" id="tunjangan_inf_transport"
                                        type="text"
                                        class="form-control mask_decimal text-end @error('tunjangan_inf_transport') is-invalid @enderror"
                                        onchange="@this.set('tunjangan_inf_transport', this.value);" value="0">
                                    @error('tunjangan_inf_transport')
                                        <div class="spanerror">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                            <div class="row row-cols-1 row-cols-sm-2 row-cols-md-3">
                                <div class="mb-2">
                                    <label>Pot BPJS</label>
                                    <input wire:model="tunjangan_pot_bpjs" id="tunjangan_pot_bpjs" type="text"
                                        class="form-control mask_decimal text-end @error('tunjangan_pot_bpjs') is-invalid @enderror"
                                        onchange="@this.set('tunjangan_pot_bpjs', this.value);" value="0">
                                    @error('tunjangan_pot_bpjs')
                                        <div class="spanerror">{{ $message }}</div>
                                    @enderror
                                </div>
                                <div class="mb-2">
                                    <label>Pot Jabatan</label>
                                    <input wire:model="tunjangan_pot_jabatan" id="tunjangan_pot_jabatan"
                                        type="text"
                                        class="form-control mask_decimal text-end @error('tunjangan_pot_jabatan') is-invalid @enderror"
                                        onchange="@this.set('tunjangan_pot_jabatan', this.value);" value="0">
                                    @error('tunjangan_pot_jabatan')
                                        <div class="spanerror">{{ $message }}</div>
                                    @enderror
                                </div>
                                <div class="mb-2">
                                    <label>Pot Jamsostek</label>
                                    <input wire:model="tunjangan_pot_jamsostek" id="tunjangan_pot_jamsostek"
                                        type="text"
                                        class="form-control mask_decimal text-end @error('tunjangan_pot_jamsostek') is-invalid @enderror"
                                        onchange="@this.set('tunjangan_pot_jamsostek', this.value);" value="0">
                                    @error('tunjangan_pot_jamsostek')
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
