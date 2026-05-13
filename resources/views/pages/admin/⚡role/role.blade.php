<div>
    <div class="card">
        <div class="card-body">
            <div wire:show="showTable" wire:cloak>
                <div class="p-3 mb-4">
                    @include('components.template.tb-filter')
                    <div class="row divtable">
                        <table id="tb_m_user" class="table tbview main-table table-hover table-md table-striped">
                            <thead class="fw-medium">
                                <tr>
                                    <th class="col-hide">id</th>
                                    <th width="1%">No</th>
                                    <th wire:click="sortBy('nama')" style="cursor: pointer;">Nama @if ($sortField === 'nama')
                                            {{ $sortDir === 'ASC' ? '↑' : '↓' }}
                                        @endif
                                    </th>
                                    <th wire:click="sortBy('ket')" style="cursor: pointer;">Keterangan @if ($sortField === 'ket')
                                            {{ $sortDir === 'ASC' ? '↑' : '↓' }}
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
                                        <td>{{ $li_data->nama }}</td>
                                        <td>{{ $li_data->ket }}</td>
                                        <td>{{ $li_data->status }}</td>
                                        @include('components.template.tbview-button')
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


                    <div wire:show="showAccessRole" wire:cloak>
                        <div class="row">
                            <div class="mt-3 mb-3 bg-light-subtle rounded-1">
                                <div class="col-form-label fs-5" style="font-weight: 600;">Akses Role</div>
                            </div>
                        </div>



                        <div class="row divtable">
                            <table id="tb_access_role"
                                class="table tbview main-table table-hover table-md table-striped">
                                <thead class="fw-medium">
                                    <tr>
                                        <th class="col-hide">id</th>
                                        <th class="print" width="1%">No</th>
                                        <th class="print">Menu</th>
                                        <th class="print">Sub Menu</th>
                                        <th class="print" width="5%">Show</th>
                                        <th class="print" width="5%">Add</th>
                                        <th class="print" width="5%">Save</th>
                                        <th class="print" width="5%">Edit</th>
                                        <th class="print" width="5%">Delete</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @php $i = 1; @endphp
                                    @forelse ($data_access_user as $index => $li_data_access)
                                        <tr wire:key='{{ $li_data_access->id }}'>
                                            <td class="col-hide">{{ $li_data_access->id }}</td>
                                            <td>{{ $i++ }}</td>
                                            <td>{{ $li_data_access->menu }}</td>
                                            <td>{{ $li_data_access->submenu }}</td>
                                            <td>
                                                <div class="form-check form-switch d-flex justify-content-center">
                                                    <input id="chkshow_{{ $li_data_access->id }}" name="chkshow[]"
                                                        data-id="{{ $li_data_access->id }}" type="checkbox"
                                                        class="form-check-input chkshow" role="switch"
                                                        {{ $li_data_access->ishow == 1 ? 'checked' : '' }}
                                                        wire:model="data_access_user.{{ $index }}.ishow"
                                                        onchange="@this.set('data_access_user.{{ $index }}.ishow', event.target.checked);">
                                                    <label class="custom-control-label"
                                                        for="chkshow_{{ $li_data_access->id }}"></label>
                                                </div>
                                            </td>
                                            <td>
                                                <div class="form-check form-switch d-flex justify-content-center">
                                                    <input id="chkadd_{{ $li_data_access->id }}" name="chkadd[]"
                                                        data-id="{{ $li_data_access->id }}" type="checkbox"
                                                        class="form-check-input chkadd" role="switch"
                                                        {{ $li_data_access->iadd == 1 ? 'checked' : '' }}
                                                        wire:model="data_access_user.{{ $index }}.iadd"
                                                        onchange="@this.set('data_access_user.{{ $index }}.iadd', event.target.checked);">
                                                    <label class="custom-control-label"
                                                        for="chkadd_{{ $li_data_access->id }}"></label>
                                                </div>
                                            </td>
                                            <td>
                                                <div class="form-check form-switch d-flex justify-content-center">
                                                    <input id="chksave_{{ $li_data_access->id }}" name="chksave[]"
                                                        data-id="{{ $li_data_access->id }}" type="checkbox"
                                                        class="form-check-input chksave" role="switch"
                                                        {{ $li_data_access->isave == 1 ? 'checked' : '' }}
                                                        wire:model="data_access_user.{{ $index }}.isave"
                                                        onchange="@this.set('data_access_user.{{ $index }}.isave', event.target.checked);">
                                                    <label class="custom-control-label"
                                                        for="chksave_{{ $li_data_access->id }}"></label>
                                                </div>
                                            </td>
                                            <td>
                                                <div class="form-check form-switch d-flex justify-content-center">
                                                    <input id="chkedit_{{ $li_data_access->id }}" name="chkedit[]"
                                                        data-id="{{ $li_data_access->id }}" type="checkbox"
                                                        class="form-check-input chkedit" role="switch"
                                                        {{ $li_data_access->iedit == 1 ? 'checked' : '' }}
                                                        wire:model="data_access_user.{{ $index }}.iedit"
                                                        onchange="@this.set('data_access_user.{{ $index }}.iedit', event.target.checked);">
                                                    <label class="custom-control-label"
                                                        for="chkedit_{{ $li_data_access->id }}"></label>
                                                </div>
                                            </td>
                                            <td>
                                                <div class="form-check form-switch d-flex justify-content-center">
                                                    <input id="chkdelete_{{ $li_data_access->id }}"
                                                        name="chkdelete[]" data-id="{{ $li_data_access->id }}"
                                                        type="checkbox" class="form-check-input chkdelete"
                                                        role="switch"
                                                        {{ $li_data_access->idelete == 1 ? 'checked' : '' }}
                                                        wire:model="data_access_user.{{ $index }}.idelete"
                                                        onchange="@this.set('data_access_user.{{ $index }}.idelete', event.target.checked);">
                                                    <label class="custom-control-label"
                                                        for="chkdelete_{{ $li_data_access->id }}"></label>
                                                </div>
                                            </td>

                                        </tr>
                                    @empty
                                        <tr>
                                            <td colspan="100%" class="text-center fw-bold fs-5">Belum Ada Data
                                            </td>
                                        </tr>
                                    @endforelse
                                </tbody>
                            </table>
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
<script>
    $(document).on("change", ".chkshow", function(e) {
        $dataid = $(this).data("id");

        if (this.checked) {
            $('#chksave_' + $dataid).prop('checked', true).change();
            $('#chkadd_' + $dataid).prop('checked', true).change();
            $('#chkedit_' + $dataid).prop('checked', true).change();
            $('#chkdelete_' + $dataid).prop('checked', true).change();

            $('#chksave_' + $dataid).removeAttr('disabled');
            $('#chkadd_' + $dataid).removeAttr('disabled');
            $('#chkedit_' + $dataid).removeAttr('disabled');
            $('#chkdelete_' + $dataid).removeAttr('disabled');

        } else {
            $('#chksave_' + $dataid).prop('checked', false).change();
            $('#chkadd_' + $dataid).prop('checked', false).change();
            $('#chkedit_' + $dataid).prop('checked', false).change();
            $('#chkdelete_' + $dataid).prop('checked', false).change();

            $('#chksave_' + $dataid).attr('disabled', true).change();
            $('#chkadd_' + $dataid).attr('disabled', true).change();
            $('#chkedit_' + $dataid).attr('disabled', true).change();
            $('#chkdelete_' + $dataid).attr('disabled', true).change();

        }

    });
</script>
