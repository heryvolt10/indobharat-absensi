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
                                    <th class="print" width="1%">No</th>
                                    <th class="print" wire:click="sortBy('nama')" style="cursor: pointer;">Nama
                                        @if ($sortField === 'nama')
                                            {{ $sortDir === 'ASC' ? '↑' : '↓' }}
                                        @endif
                                    </th>
                                    <th class="print" wire:click="sortBy('pusat')" style="cursor: pointer;">Status Site
                                        @if ($sortField === 'pusat')
                                            {{ $sortDir === 'ASC' ? '↑' : '↓' }}
                                        @endif
                                    </th>
                                    <th class="print" wire:click="sortBy('email')" style="cursor: pointer;">Email
                                        @if ($sortField === 'email')
                                            {{ $sortDir === 'ASC' ? '↑' : '↓' }}
                                        @endif
                                    </th>
                                    <th class="print" wire:click="sortBy('no_tlp')" style="cursor: pointer;">No. Tlp
                                        @if ($sortField === 'no_tlp')
                                            {{ $sortDir === 'ASC' ? '↑' : '↓' }}
                                        @endif
                                    </th>
                                    <th class="print" wire:click="sortBy('alamat')" style="cursor: pointer;">Alamat
                                        @if ($sortField === 'alamat')
                                            {{ $sortDir === 'ASC' ? '↑' : '↓' }}
                                        @endif
                                    </th>
                                    <th class="print" wire:click="sortBy('kontak_person')" style="cursor: pointer;">
                                        Kontak Person @if ($sortField === 'kontak_person')
                                            {{ $sortDir === 'ASC' ? '↑' : '↓' }}
                                        @endif
                                    </th>
                                    <th class="print" width="5%">Status</th>
                                    <th class="last-col sticky-col" width="5%">#</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse ($data_rows as $li_data)
                                    <tr>
                                        <td class="col-hide">{{ $li_data->id }}</td>
                                        <td>
                                            {{ ($data_rows->currentPage() - 1) * $data_rows->perPage() + $loop->index + 1 }}
                                        </td>
                                        <td>{{ $li_data->nama }}</td>
                                        <td>{{ $li_data->pusat }}</td>
                                        <td>{{ $li_data->email }}</td>
                                        <td>{{ $li_data->no_tlp }}</td>
                                        <td>{{ $li_data->alamat }}</td>
                                        <td>{{ $li_data->kontak_person }}</td>
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
                            <label>Email</label>
                            <input wire:model="email" id="email" type="text"
                                class="form-control @error('email') is-invalid @enderror">
                            @error('email')
                                <div class="spanerror">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="mb-2">
                            <label>Alamat</label>
                            <textarea wire:model="alamat" id="alamat" type="text" class="form-control @error('alamat') is-invalid @enderror"></textarea>
                            @error('alamat')
                                <div class="spanerror">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="mb-2">
                            <label>No Tlp</label>
                            <input wire:model="no_tlp" id="no_tlp" type="text"
                                class="form-control @error('no_tlp') is-invalid @enderror">
                            @error('no_tlp')
                                <div class="spanerror">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="mb-2">
                            <label>Kontak Person</label>
                            <input wire:model="kontak_person" id="kontak_person" type="text"
                                class="form-control @error('kontak_person') is-invalid @enderror">
                            @error('kontak_person')
                                <div class="spanerror">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="mb-2">
                            <label></label>
                            <div class="form-check fs-3">
                                <input wire:model="i_pusat" class="form-check-input" type="checkbox"
                                    @if ($i_pusat == 1) checked @endif id="i_pusat">
                                <label class="form-check-label" for="i_pusat">Head Officec</label>
                            </div>
                            @error('i_pusat')
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
