<div>
    <div class="card">
        <div class="card-body">
            <div wire:show="showTable" wire:cloak>
                <div class="p-3 mb-4">
                    @include('components.template.tb-filter')
                    <div class="row divtable">
                        <table id="tbindex_user" class="table tbview main-table table-hover ">
                            <thead class="fw-medium">
                                <tr>
                                    <th class="col-hide">id</th>
                                    <th width="1%">No</th>
                                    <th class="print" wire:click="sortBy('org')" style="cursor: pointer;">Org
                                        @if ($sortField === 'org')
                                            {{ $sortDir === 'asc' ? '↑' : '↓' }}
                                        @endif
                                    </th>

                                    <th class="print" wire:click="sortBy('NIK')" style="cursor: pointer;">NIK
                                        @if ($sortField === 'NIK')
                                            {{ $sortDir === 'asc' ? '↑' : '↓' }}
                                        @endif
                                    </th>
                                    <th wire:click="sortBy('nama')" style="cursor: pointer;">Nama @if ($sortField === 'nama')
                                            {{ $sortDir === 'ASC' ? '↑' : '↓' }}
                                        @endif
                                    </th>
                                    <th class="print" wire:click="sortBy('gender')" style="cursor: pointer;">Gender
                                        @if ($sortField === 'gender')
                                            {{ $sortDir === 'asc' ? '↑' : '↓' }}
                                        @endif
                                    </th>
                                    <th class="print" wire:click="sortBy('agama')" style="cursor: pointer;">Agama
                                        @if ($sortField === 'agama')
                                            {{ $sortDir === 'asc' ? '↑' : '↓' }}
                                        @endif
                                    </th>
                                    <th class="print" wire:click="sortBy('alamat')" style="cursor: pointer;">Alamat
                                        @if ($sortField === 'alamat')
                                            {{ $sortDir === 'asc' ? '↑' : '↓' }}
                                        @endif
                                    </th>
                                    <th class="print" wire:click="sortBy('divisi')" style="cursor: pointer;">Divisi
                                        @if ($sortField === 'divisi')
                                            {{ $sortDir === 'asc' ? '↑' : '↓' }}
                                        @endif
                                    </th>
                                    <th class="print" wire:click="sortBy('jabatan')" style="cursor: pointer;">Jabatan
                                        @if ($sortField === 'jabatan')
                                            {{ $sortDir === 'asc' ? '↑' : '↓' }}
                                        @endif
                                    </th>

                                    <th class="print" wire:click="sortBy('no_npwp')" style="cursor: pointer;">No NPWP
                                        @if ($sortField === 'no_npwp')
                                            {{ $sortDir === 'asc' ? '↑' : '↓' }}
                                        @endif
                                    </th>
                                    <th class="print" wire:click="sortBy('no_bpjs')" style="cursor: pointer;">No BPJS
                                        @if ($sortField === 'no_bpjs')
                                            {{ $sortDir === 'asc' ? '↑' : '↓' }}
                                        @endif
                                    </th>
                                    <th class="print" wire:click="sortBy('tgl_bekerja')" style="cursor: pointer;">
                                        Tanggal Berkerja
                                        @if ($sortField === 'tgl_bekerja')
                                            {{ $sortDir === 'asc' ? '↑' : '↓' }}
                                        @endif
                                    </th>
                                    <th class="print" wire:click="sortBy('ptkp')" style="cursor: pointer;">PTKP
                                        @if ($sortField === 'ptkp')
                                            {{ $sortDir === 'asc' ? '↑' : '↓' }}
                                        @endif
                                    </th>
                                    <th class="print" wire:click="sortBy('nama_bank')" style="cursor: pointer;">Nama
                                        Bank
                                        @if ($sortField === 'nama_bank')
                                            {{ $sortDir === 'asc' ? '↑' : '↓' }}
                                        @endif
                                    </th>
                                    <th class="print" wire:click="sortBy('no_rek')" style="cursor: pointer;">No
                                        Rek
                                        @if ($sortField === 'no_rek')
                                            {{ $sortDir === 'asc' ? '↑' : '↓' }}
                                        @endif
                                    </th>
                                    <th class="print" wire:click="sortBy('nama_rek')" style="cursor: pointer;">Pemilik
                                        Rek
                                        @if ($sortField === 'nama_rek')
                                            {{ $sortDir === 'asc' ? '↑' : '↓' }}
                                        @endif
                                    </th>
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
                                        <td>{{ $li_data->org }}</td>
                                        <td>{{ $li_data->NIK }}</td>
                                        <td>{{ $li_data->nama }}</td>
                                        <td>{{ $li_data->gender }}</td>
                                        <td>{{ $li_data->agama }}</td>
                                        <td>{{ $li_data->alamat }}</td>
                                        <td>{{ $li_data->divisi }}</td>
                                        <td>{{ $li_data->jabatan }}</td>
                                        <td>{{ $li_data->no_npwp }}</td>
                                        <td>{{ $li_data->no_bpjs }}</td>
                                        <td>{{ $li_data->tgl_bekerja }}</td>
                                        <td>{{ $li_data->ptkp }}</td>
                                        <td>{{ $li_data->nama_bank }}</td>
                                        <td>{{ $li_data->no_rek }}</td>
                                        <td>{{ $li_data->nama_rek }}</td>
                                        <td class="col-hide">{{ $li_data->f_status }}</td>
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


                    <div class="row bg-secondary-subtle mb-2 rounded-1 pt-1">
                        <div class="mb-2 fs-5 fw-bold">Data Login</div>
                    </div>

                    <div class="row row-cols-1 row-cols-sm-2 row-cols-md-3 mb-3">
                        <div class="mb-2">
                            <label>NIK</label>
                            <input wire:model="NIK" id="NIK" type="text"
                                class="form-control @error('NIK') is-invalid @enderror">
                            @error('NIK')
                                <div class="spanerror">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="mb-2">
                            <label>Role</label>
                            <div class="input-group">
                                <input wire:model="f_role_tag" id="f_role_tag" type="text"
                                    onchange="@this.set('f_role_tag', this.value);"
                                    class="form-control onlyread @error('f_role') is-invalid @enderror" readonly>
                                <input wire:model="f_role" id="f_role" name="f_role" type="text"
                                    onchange="@this.set('f_role', this.value);" class="form-control" hidden>
                                <button class="btn btn-success listdata" type="button" data-idinput="f_role"
                                    data-poptitle="role" data-tblist="list_role" data-type="0"><i
                                        class="ti ti-search"></i></button>
                            </div>
                            @error('f_role')
                                <div class="spanerror">{{ $message }}</div>
                            @enderror
                        </div>

                    </div>


                    <div class="row bg-secondary-subtle mb-2 rounded-1 pt-1">
                        <div class="mb-2 fs-5 fw-bold">Data Diri</div>
                    </div>

                    <div class="row row-cols-1 row-cols-sm-2 row-cols-md-3 mb-3">
                        <div class="mb-2">
                            <label>Nama</label>
                            <input wire:model="nama" id="nama" type="text"
                                class="form-control @error('nama') is-invalid @enderror">
                            @error('nama')
                                <div class="spanerror">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="mb-2">
                            <label>Gender</label>
                            <div class="input-group">
                                <input wire:model="f_gender_tag" id="f_gender_tag" type="text"
                                    onchange="@this.set('f_gender_tag', this.value);"
                                    class="form-control onlyread @error('f_gender') is-invalid @enderror" readonly>
                                <input wire:model="f_gender" id="f_gender" name="f_gender" type="text"
                                    onchange="@this.set('f_gender', this.value);" class="form-control" hidden>
                                <button class="btn btn-success listdata" type="button" data-idinput="f_gender"
                                    data-poptitle="gender" data-tblist="list_gender" data-type="0"><i
                                        class="ti ti-search"></i></button>
                            </div>
                            @error('f_gender')
                                <div class="spanerror">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="mb-2">
                            <label>Agama</label>
                            <div class="input-group">
                                <input wire:model="f_agama_tag" id="f_agama_tag" type="text"
                                    onchange="@this.set('f_agama_tag', this.value);"
                                    class="form-control onlyread @error('f_agama') is-invalid @enderror" readonly>
                                <input wire:model="f_agama" id="f_agama" name="f_agama" type="text"
                                    onchange="@this.set('f_agama', this.value);" class="form-control" hidden>
                                <button class="btn btn-success listdata" type="button" data-idinput="f_agama"
                                    data-poptitle="agama" data-tblist="list_agama" data-type="0"><i
                                        class="ti ti-search"></i></button>
                            </div>
                            @error('f_agama')
                                <div class="spanerror">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="mb-2 ">
                            <label>Alamat</label>
                            <textarea wire:model="alamat" id="alamat" type="text"
                                class="form-control @error('alamat') is-invalid @enderror"></textarea>
                            @error('alamat')
                                <div class="spanerror">{{ $message }}</div>
                            @enderror
                        </div>



                    </div>

                    <div class="row  bg-secondary-subtle mb-2 rounded-1 pt-1">
                        <div class="mb-2 fs-5 fw-bold">Data Pekerjaan</div>
                    </div>
                    <div class="row row-cols-1 row-cols-sm-2 row-cols-md-3 mb-3">
                        <div class="mb-2">
                            <label>Divisi</label>
                            <div class="input-group">
                                <input wire:model="f_divisi_tag" id="f_divisi_tag" type="text"
                                    onchange="@this.set('f_divisi_tag', this.value);"
                                    class="form-control onlyread @error('f_divisi') is-invalid @enderror" readonly>
                                <input wire:model="f_divisi" id="f_divisi" name="f_divisi" type="text"
                                    onchange="@this.set('f_divisi', this.value);" class="form-control" hidden>
                                <button class="btn btn-success listdata" type="button" data-idinput="f_divisi"
                                    data-poptitle="divisi" data-tblist="list_divisi" data-type="0"><i
                                        class="ti ti-search"></i></button>
                            </div>
                            @error('f_divisi')
                                <div class="spanerror">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="mb-2">
                            <label>Jabatan</label>
                            <div class="input-group">
                                <input wire:model="f_jabatan_tag" id="f_jabatan_tag" type="text"
                                    onchange="@this.set('f_jabatan_tag', this.value);"
                                    class="form-control onlyread @error('f_jabatan') is-invalid @enderror" readonly>
                                <input wire:model="f_jabatan" id="f_jabatan" name="f_jabatan" type="text"
                                    onchange="@this.set('f_jabatan', this.value);" class="form-control" hidden>
                                <button class="btn btn-success listdata" type="button" data-idinput="f_jabatan"
                                    data-poptitle="jabatan" data-tblist="list_jabatan" data-type="0"><i
                                        class="ti ti-search"></i></button>
                            </div>
                            @error('f_jabatan')
                                <div class="spanerror">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="mb-2 divOrg">
                            <label>Site</label>
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
                        <div class="mb-2">
                            <label>No NPWP</label>
                            <input wire:model="no_npwp" id="no_npwp" type="text"
                                class="form-control @error('no_npwp') is-invalid @enderror">
                            @error('no_npwp')
                                <div class="spanerror">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="mb-2">
                            <label>No BPJS</label>
                            <input wire:model="no_bpjs" id="no_bpjs" type="text"
                                class="form-control @error('no_bpjs') is-invalid @enderror">
                            @error('no_bpjs')
                                <div class="spanerror">{{ $message }}</div>
                            @enderror
                        </div>


                        <div class="mb-2">
                            <label>Tanggal Bekerja</label>
                            <input wire:model="tgl_bekerja" id="tgl_bekerja" type="text"
                                onchange="@this.set('tgl_bekerja', this.value);"
                                class="form-control dDate @error('tgl_bekerja') is-invalid @enderror" readonly>
                            @error('tgl_bekerja')
                                <div class="spanerror">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="mb-2">
                            <label>PTKP</label>
                            <div class="input-group">
                                <input wire:model="f_ptkp_tag" id="f_ptkp_tag" type="text"
                                    onchange="@this.set('f_ptkp_tag', this.value);"
                                    class="form-control onlyread @error('f_ptkp') is-invalid @enderror" readonly>
                                <input wire:model="f_ptkp" id="f_ptkp" name="f_ptkp" type="text"
                                    onchange="@this.set('f_ptkp', this.value);" class="form-control" hidden>
                                <button class="btn btn-success listdata" type="button" data-idinput="f_ptkp"
                                    data-poptitle="ptkp" data-tblist="list_ptkp" data-type="1"><i
                                        class="ti ti-search"></i></button>
                            </div>
                            @error('f_ptkp')
                                <div class="spanerror">{{ $message }}</div>
                            @enderror
                        </div>

                    </div>
                    <div class="row  bg-secondary-subtle mb-2 rounded-1 pt-1">
                        <div class="mb-2 fs-5 fw-bold">Data Bank</div>
                    </div>
                    <div class="row row-cols-1 row-cols-sm-2 row-cols-md-3 mb-3">
                        <div class="mb-2">
                            <label>Nama Bank</label>
                            <input wire:model="nama_bank" id="nama_bank" type="text"
                                class="form-control @error('nama_bank') is-invalid @enderror">
                            @error('nama_bank')
                                <div class="spanerror">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="mb-2">
                            <label>No Rek</label>
                            <input wire:model="no_rek" id="no_rek" type="text"
                                class="form-control @error('no_rek') is-invalid @enderror">
                            @error('no_rek')
                                <div class="spanerror">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="mb-2">
                            <label>Pemilik</label>
                            <input wire:model="nama_rek" id="nama_rek" type="text"
                                class="form-control @error('nama_rek') is-invalid @enderror">
                            @error('nama_rek')
                                <div class="spanerror">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                    <div class="row row-cols-1 row-cols-sm-2 row-cols-md-3 mb-3">
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
