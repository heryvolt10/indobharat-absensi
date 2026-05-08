<div>
    <div class="border-bottom p-3 mb-2 d-flex gap-2 btn-group-lg">
        <button wire:click="buttonBack" id="buttonBack" type="button" class="btn btn-primary rounded-1 btn_frm_back"
            data-toggle="tooltip" data-placement="bottom" title="Kembali">
            <i class="fas fa-arrow-left"></i>
        </button>

        @if ($accessSubMenu->isave == '1')
            <button id="btn_save" type="submit" class="btn btn-primary btn_frm_save rounded-1"
                onclick="loading_alert();" wire:loading.attr='disabled' data-toggle="tooltip" data-placement="bottom"
                title="Simpan">
                <i class="far fa-save"></i>
            </button>
        @endif
    </div>
</div>
