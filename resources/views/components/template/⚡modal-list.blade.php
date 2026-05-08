<?php

use Livewire\Component;
use Livewire\Attributes\On;
use Illuminate\Support\Facades\DB;
use Livewire\WithPagination;
use Livewire\WithoutUrlPagination;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Pagination\Paginator;

new class extends Component {
    use WithPagination, WithoutUrlPagination;

    public $showModalList = false;

    public $ses_user_id, $ses_user_frole, $ses_user_forg;

    public $modalListfilterSearch, $modallistHeader;

    public $listmodal_idinput, $listmodal_tblist, $listmodal_type, $listmodal_custom1, $listmodal_custom2, $listmodal_custom3, $listmodal_custom4, $listmodal_custom5;

    public function mount()
    {
        $this->ses_user_id = session('user_id');
        $this->ses_user_frole = session('user_frole');
        $this->ses_user_forg = session('user_forg');
    }

    #[On('dp-modal-list-open')]
    public function modallist_show()
    {
        $this->showModalList = true;
        $this->js("$('#modal_list').modal('show');");
    }

    #[On('dp_modalListClose')]
    public function modallist_close()
    {
        $this->showModalList = false;
        $this->reset();
    }

    public function render()
    {
        $query = '';
        if ($this->listmodal_type == '0') {
            if ($this->listmodal_tblist == 'list_status') {
                $tipeStatus = $this->listmodal_custom1;
                $query = \App\Models\M_mt_status::detail(null, 1, $this->modalListfilterSearch, null);
                $query .= ' AND A.f_status <> 1 ';

                if ($tipeStatus == '1') {
                    $query .= ' AND A.id IN (1,2) ';
                }
                $query .= ' ORDER BY A.nama ';
            }

            if ($this->listmodal_tblist == 'list_users') {
                $query = \App\Models\M_users::detail(null, 1, $this->modalListfilterSearch, null);
                $query .= ' AND A.f_status <> 1 ';
                $query .= ' ORDER BY A.name ';
            }

            if ($this->listmodal_tblist == 'list_role') {
                $query = \App\Models\M_users_role::detail(null, 1, $this->modalListfilterSearch, null);
                $query .= ' AND A.f_status <> 1 ';
                $query .= ' ORDER BY A.nama ';
            }

            if ($this->listmodal_tblist == 'list_org') {
                $query = \App\Models\M_mt_org::detail(null, 1, $this->modalListfilterSearch, null, 1);
                $query .= ' AND X.f_status <> 1 ';
                $query .= ' ORDER BY X.nama ';
            }

            if ($this->listmodal_tblist == 'list_unit') {
                $query = \App\Models\M_mt_unit::detail(null, 1, $this->modalListfilterSearch, null);
                $query .= ' AND A.f_status <> 1 ';
                $query .= ' ORDER BY A.nama ';
            }

            if ($this->listmodal_tblist == 'list_gender') {
                $query = \App\Models\M_mt_gender::detail(null, 1, $this->modalListfilterSearch, null);
                $query .= ' AND A.f_status <> 1 ';
                $query .= ' ORDER BY A.nama ';
            }

            if ($this->listmodal_tblist == 'list_menu') {
                $query = \App\Models\M_users_menu::detail(null, 1, $this->modalListfilterSearch, null);
                $query .= ' AND A.f_status <> 1 ';
                $query .= ' ORDER BY A.nama ';
            }

            if ($this->listmodal_tblist == 'list_divisi') {
                $query = \App\Models\M_mt_divisi::detail(null, 1, $this->modalListfilterSearch, null);
                $query .= ' AND A.f_status <> 1 ';
                $query .= ' ORDER BY A.nama ';
            }
            if ($this->listmodal_tblist == 'list_jabatan') {
                $query = \App\Models\M_mt_jabatan::detail(null, 1, $this->modalListfilterSearch, null);
                $query .= ' AND A.f_status <> 1 ';
                $query .= ' ORDER BY A.nama ';
            }
            if ($this->listmodal_tblist == 'list_grade') {
                $query = \App\Models\M_mt_grade::detail(null, 1, $this->modalListfilterSearch, null);
                $query .= ' AND A.f_status <> 1 ';
                $query .= ' ORDER BY A.nama ';
            }
            if ($this->listmodal_tblist == 'list_role') {
                $query = \App\Models\M_users_role::detail(null, 1, $this->modalListfilterSearch, null);
                $query .= ' AND A.f_status <> 1 ';
                $query .= ' ORDER BY A.nama ';
            }
            if ($this->listmodal_tblist == 'list_agama') {
                $query = \App\Models\M_mt_agama::detail(null, 1, $this->modalListfilterSearch, null);
                $query .= ' AND A.f_status <> 1 ';
                $query .= ' ORDER BY A.nama ';
            }

            $this->modallistHeader = [(object) ['data' => 'list-nomor', 'title' => 'No', 'className' => '', 'width' => '2%'], (object) ['data' => 'list-pilih', 'title' => 'Pilih', 'className' => 'idpick', 'width' => '3%'], (object) ['data' => 'id', 'title' => 'id', 'className' => 'id col-hide', 'width' => '1%'], (object) ['data' => 'nama', 'title' => 'Nama', 'className' => 'nama', 'width' => ''], (object) ['data' => 'f_org', 'title' => 'Kode Org', 'className' => 'f_org' . $this->ses_user_frole == 1 ? '' : ' col-hide', 'width' => ''], (object) ['data' => 'org', 'title' => 'Org', 'className' => 'org' . $this->ses_user_frole == 1 ? '' : ' col-hide', 'width' => '']];
        } else {
            // if ($this->listmodal_tblist == 'list_akun') {
            //     $query = \App\Models\M_mt_akun::detail(null, 1, $this->modalListfilterSearch, null);
            //     $query .= ' AND A.f_status <> 1 ';
            //     $query .= ' ORDER BY E.nama, D.nama, A.nama ';

            //     $this->modallistHeader = [(object) ['data' => 'list-nomor', 'title' => 'No', 'className' => '', 'width' => '2%'], (object) ['data' => 'list-pilih', 'title' => 'Pilih', 'className' => 'idpick', 'width' => '3%'], (object) ['data' => 'id', 'title' => 'id', 'className' => 'id col-hide', 'width' => '1%'], (object) ['data' => 'nama', 'title' => 'Nama', 'className' => 'nama', 'width' => ''], (object) ['data' => 'akun_head1', 'title' => 'Akun Head 1', 'className' => 'akun_head1', 'width' => ''], (object) ['data' => 'akun_head2', 'title' => 'Akun Head 2', 'className' => 'akun_head2', 'width' => ''], (object) ['data' => 'f_org', 'title' => 'Kode Org', 'className' => 'f_org' . $this->ses_user_frole == 1 ? '' : ' col-hide', 'width' => ''], (object) ['data' => 'org', 'title' => 'Org', 'className' => 'org' . $this->ses_user_frole == 1 ? '' : ' col-hide', 'width' => '']];
            // }

            if ($this->listmodal_tblist == 'list_ptkp') {
                $query = \App\Models\M_mt_ptkp::detail(null, 1, $this->modalListfilterSearch, null);
                $query .= ' AND A.f_status <> 1 ';
                $query .= ' ORDER BY A.id ';
            }

            // $this->modallistHeader = [(object) ['data' => 'list-nomor', 'title' => 'No', 'className' => '', 'width' => '2%'], (object) ['data' => 'list-pilih', 'title' => 'Pilih', 'className' => 'idpick', 'width' => '3%'], (object) ['data' => 'id', 'title' => 'id', 'className' => 'id col-hide', 'width' => '1%'], (object) ['data' => 'nama', 'title' => 'Nama', 'className' => 'nama', 'width' => ''], (object) ['data' => 'nilai', 'title' => 'Nilai PTKP', 'className' => 'nilai', 'width' => ''], (object) ['data' => 'ket', 'title' => 'Keterangan', 'className' => 'ket', 'width' => ''], (object) ['data' => 'f_org', 'title' => 'Kode Org', 'className' => 'f_org' . $this->ses_user_frole == 1 ? '' : ' col-hide', 'width' => ''], (object) ['data' => 'org', 'title' => 'Org', 'className' => 'org' . $this->ses_user_frole == 1 ? '' : ' col-hide', 'width' => '']];

            $this->modallistHeader = [(object) ['data' => 'list-nomor', 'title' => 'No', 'className' => '', 'width' => '2%'], (object) ['data' => 'list-pilih', 'title' => 'Pilih', 'className' => 'idpick', 'width' => '3%'], (object) ['data' => 'id', 'title' => 'id', 'className' => 'id col-hide', 'width' => '1%'], (object) ['data' => 'nama', 'title' => 'Nama', 'className' => 'nama', 'width' => ''], (object) ['data' => 'nilai', 'title' => 'Nilai PTKP', 'className' => 'nilai', 'width' => ''], (object) ['data' => 'ket', 'title' => 'Keterangan', 'className' => 'ket', 'width' => ''], (object) ['data' => 'f_org', 'title' => 'Kode Org', 'className' => 'f_org' . $this->ses_user_frole == 1 ? '' : ' col-hide', 'width' => ''], (object) ['data' => 'org', 'title' => 'Org', 'className' => 'org' . $this->ses_user_frole == 1 ? '' : ' col-hide', 'width' => '']];
        }

        if ($query != '') {
            $perPage = 5;
            $currentPage = Paginator::resolveCurrentPage();
            $allRecords = DB::select($query);

            $totalRecords = count($allRecords);

            // 2. Manually slice the array
            $offset = $currentPage * $perPage - $perPage;
            $itemsForCurrentPage = array_slice($allRecords, $offset, $perPage);

            // 3. Instantiate LengthAwarePaginator
            $paginator = new LengthAwarePaginator($itemsForCurrentPage, $totalRecords, $perPage, $currentPage, [
                'path' => request()->path(),
                'query' => request()->query(),
            ]);

            return $this->view([
                'modallistColumn' => $paginator,
                'modallistHeader' => $this->modallistHeader,
            ]);
        } else {
            return $this->view([
                'modallistColumn' => '',
                'modallistHeader' => '',
            ]);
        }
    }

    public function updatedmodalListfilterSearch()
    {
        $this->resetPage();
    }
};
?>

<div x-data="{ show: @entangle('showModalList') }" x-show="show">
    <div wire:ignore.self class="modal fade lg" id="modal_list" data-bs-backdrop="static" data-bs-keyboard="false"
        tabindex="-1" aria-labelledby="modal_listLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header" wire:ignore>
                    <h1 class="modal-title fs-5" id="modal_listLabel"></h1>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="container">
                    <div class="modal-body">
                        <input wire:ignore type="hidden" id="listmodal_idinput">
                        <input type="hidden" id="listmodal_tblist" wire:model='listmodal_tblist'
                            onchange="@this.set('listmodal_tblist', this.value);">
                        <input type="hidden" id="listmodal_type" wire:model='listmodal_type'
                            onchange="@this.set('listmodal_type', this.value);">
                        <input type="hidden" id="listmodal_custom1" wire:model='listmodal_custom1'
                            onchange="@this.set('listmodal_custom1', this.value);">
                        <input type="hidden" id="listmodal_custom2" wire:model='listmodal_custom2'
                            onchange="@this.set('listmodal_custom2', this.value);">
                        <input type="hidden" id="listmodal_custom3" wire:model='listmodal_custom3'
                            onchange="@this.set('listmodal_custom3', this.value);">
                        <input type="hidden" id="listmodal_custom4" wire:model='listmodal_custom4'
                            onchange="@this.set('listmodal_custom4', this.value);">
                        <input type="hidden" id="listmodal_custom5" wire:model='listmodal_custom5'
                            onchange="@this.set('listmodal_custom5', this.value);">

                        <div class="row justify-content-end">
                            @if ($modallistColumn != '' || $modallistColumn != '')
                                <div class="col-sm-8">
                                </div>
                                <div class="col-md-4">
                                    <input id="modalListfilterSearch" type="search"
                                        wire:model.live.debounce.750ms="modalListfilterSearch"
                                        class="form-control"placeholder="Cari Data....">
                                </div>
                            @endif
                        </div>
                        <div class="row mb-4 p-2">
                            <table id="tb_modal_list"
                                class="table tbview main-table table-hover table-md table-striped">
                                @if ($modallistColumn != '' || $modallistColumn != '')
                                    <thead class="fw-medium">
                                        <tr>
                                            @foreach ($modallistHeader as $listHeader)
                                                <th class="{{ $listHeader->className }}"
                                                    width="{{ $listHeader->width }}">
                                                    {{ $listHeader->title }}</th>
                                            @endforeach
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @forelse ($modallistColumn as $index => $listColumn)
                                            @php $numberingList = ($modallistColumn->currentPage() - 1) * $modallistColumn->perPage() + $loop->index + 1; @endphp
                                            {{-- jadikan array pada list column --}}
                                            @php  $modallistColumn[$index] = (array) $listColumn; @endphp
                                            <tr>
                                                @foreach ($modallistHeader as $listHeader)
                                                    @if ($listHeader->data == 'list-nomor')
                                                        <td class="{{ $listHeader->className }}"
                                                            width="{{ $listHeader->width }}">
                                                            @php
                                                                echo $numberingList;
                                                            @endphp
                                                        </td>
                                                    @elseif($listHeader->data == 'list-pilih')
                                                        <td class="{{ $listHeader->className }}"
                                                            width="{{ $listHeader->width }}">
                                                            <button wire:key="{{ $modallistColumn[$index]['id'] }}"
                                                                id="btn_pick"
                                                                class="btn btn-primary rounded-1 btn-sm modallist_btn_pick"><i
                                                                    class="ti ti-check"></i></button>
                                                        </td>
                                                    @else
                                                        <td class="{{ $listHeader->className }}"
                                                            width="{{ $listHeader->width }}">
                                                            {{ $modallistColumn[$index][$listHeader->data] }}
                                                        </td>
                                                    @endif
                                                @endforeach
                                            </tr>
                                        @empty
                                            <tr>
                                                <td colspan="100%" class="text-center fw-bold fs-5">Tidak Ada Data
                                                </td>
                                            </tr>
                                        @endforelse
                                    </tbody>
                                @else
                                    <div class="fs-5 text-center">List Belum Dibuat</div>
                                @endif
                            </table>
                        </div>
                        <div class="mt-2">
                            @if ($modallistColumn != '')
                                {{ $modallistColumn->links('template.navpaginate', ['scrollTo' => false]) }}
                            @endif
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button id="modallist_close" wire:click='modallist_close' type="button"
                            class="btn btn-secondary rounded-1" data-bs-dismiss="modal">Keluar</button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

@push('scripts')
    <script data-navigate-once>
        // ============================= POPUP MODAL LIST =============================
        $(document).on('click', ".listdata", function(e) {
            $list_tbilst = $(this).data('tblist');

            $("#listmodal_poptitle").val($(this).data('poptitle')).change();
            $("#listmodal_tblist").val($(this).data('tblist')).change();
            $("#listmodal_type").val($(this).data('type')).change();

            $('#listmodal_idinput').val($(this).data('idinput'));
            $('#modal_listLabel').html('List ' + $(this).data('poptitle'));

            $mustchek = $(this).data('mustcheck');

            if ($mustchek == "1") {
                $mustcheck_id = $(this).data('mustcheck_id');
                $mustcheck_label = $(this).data('mustcheck_label');
                if ($("#" + $mustcheck_id).val() == "") {
                    Swal.fire(
                        '',
                        "Pilih " + $mustcheck_label + " terlebih dahulu",
                        "info",
                    )
                    return false;
                }
            }

            window.dispatchEvent(new CustomEvent('dp-modal-list-open'));


        });
        // ============================= POPUP MODAL LIST END =============================

        // ============================= CHECK BEFORE =============================

        function cekinput_beforelist($tblist, $data_mustcheck) {
            if ($tblist == 'list_kota') {
                if ($fProvinsi == "") {
                    return "Provinsi";
                } else {
                    return "";
                }
            }
        }
        // ============================= CHECK BEFORE END=============================


        // ============================= PICK BUTTON LIST =============================
        $(document).on('click', '.modallist_btn_pick', function(e) {
            $idinput = $("#listmodal_idinput").val();
            $idpick = $(this).closest("tr").find("td.id").html();
            $nama = $(this).closest("tr").find("td.nama").html();

            $("#" + $idinput).val($.trim($idpick)).change();
            $("#" + $idinput + '_tag').val($.trim($nama)).change();
            window.dispatchEvent(new CustomEvent('dp_modalListClose'));
            $('#modal_list').modal('hide');
        });
        // ============================= PICK BUTTON LIST =============================
    </script>
@endpush
