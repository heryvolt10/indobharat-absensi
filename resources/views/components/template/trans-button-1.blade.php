<div>
    <div class="border-bottom p-3 mb-2 d-flex gap-2 btn-group-lg">
        @if ($accessSubMenu->isave == '1')
            <button id="btn_save" type="submit" class="btn btn-primary btn_frm btn_frm_save rounded-1"
                onclick="loading_alert();" wire:loading.attr='disabled' data-toggle="tooltip" data-placement="bottom"
                title="Simpan">
                <i class="far fa-save"></i>
            </button>
        @endif
    </div>
</div>
