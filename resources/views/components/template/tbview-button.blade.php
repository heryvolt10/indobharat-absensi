<td class="last-col sticky-col">
    <div class="btn-group btn-group-sm d-flex justify-content-center btn_index gap-1" id="baction">
        @if (!isset($no_tbview_edit) || $no_tbview_edit != '1')
            @if ($accessSubMenu->iedit == 1)
                <button wire:click="store({{ $li_data->id }})" id="tbedit"
                    class="btn btn-info rounded-1 btn_index_edit" data-toggle="tooltip" data-placement="bottom"
                    title="Edit Data"><i class="ti ti-edit fs-1"></i></button>
            @endif
        @endif

        @if (!isset($no_tbview_delete) || $no_tbview_delete != '1')
            @if ($accessSubMenu->idelete == 1 && $li_data->f_status == 2)
                <button id="tbdelete" data-id="{{ $li_data->id }}" class="btn btn-danger rounded-1 btn_index_delete"
                    data-toggle="tooltip" data-placement="bottom" title="Hapus Data"><i
                        class="ti ti-trash fs-1"></i></button>
            @endif
        @endif

    </div>
</td>
