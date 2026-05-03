<div>
    <div class="card">
        <div class="card-body">
            <div wire:show="showTable" wire:cloak>
                <div class="p-3 mb-4">
                    @include('components.template.tb-filter')
                    <div class="row divtable">
                        <table id="tb_m_menu" class="table tbview main-table table-hover table-md table-striped">
                            <thead class="fw-medium">
                                <tr>
                                    <th class="col-hide">id</th>
                                    <th width="1%">No</th>
                                    <th wire:click="sortBy('nama')" style="cursor: pointer;">Nama @if ($sortField === 'nama')
                                            {{ $sortDir === 'ASC' ? '↑' : '↓' }}
                                        @endif
                                    </th>
                                    <th wire:click="sortBy('seq')" style="cursor: pointer;">Seq @if ($sortField === 'seq')
                                            {{ $sortDir === 'ASC' ? '↑' : '↓' }}
                                        @endif
                                    </th>
                                    <th>Icon</th>
                                    <th>Keterangan</th>
                                    <th width="5%">Status</th>
                                    <th class="last-col sticky-col" width="5%">#</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse ($data_rows as $li_data)
                                    <tr wire:key='{{ $li_data->id }}'>
                                        <td class="col-hide">{{ $li_data->id }}</td>
                                        <td>{{ ($data_rows->currentPage() - 1) * $data_rows->perPage() + $loop->index + 1 }}
                                        </td>
                                        <td>{{ $li_data->nama }}</td>
                                        <td>{{ $li_data->seq }}</td>
                                        <td>{{ $li_data->icon }}</td>
                                        <td>{{ $li_data->ket }}</td>
                                        <td>{{ $li_data->status }}</td>
                                        @include('components.template.tbview-button-1')
                                    </tr>
                                @empty
                                    @include('components.template.no-data-table')
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                    @include('components.template.table-page')
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
                        <div class="mb-2">
                            <label>Seq</label>
                            <input wire:model="seq" id="seq" type="text"
                                onchange="@this.set('seq', this.value == '' ? '0' : this.value);"
                                class="form-control mask_onlynumber text-end @error('seq') is-invalid @enderror">
                            @error('seq')
                                <div class="spanerror">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="mb-2">
                            <label>Icon</label>
                            <input wire:model="icon" id="icon" type="text"
                                class="form-control @error('icon') is-invalid @enderror">
                            @error('icon')
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
                                    class="form-control onlyread @error('f_status') is-invalid @enderror" readonly>
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
                                    class="form-control onlyread @error('f_org') is-invalid @enderror" readonly>
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
