<div>
    <div class="card">
        <div class="card-body">
            <form wire:submit="save" id="frmdata" class="frmform" enctype="multipart/form-data">
                @csrf
                <!-- ---------------------------------------------- button --------------------------------------------- -->
                @include('components.template.trans-button-1')
                <!-- ---------------------------------------------- button End --------------------------------------------- -->

                <div class="row row-cols-1 row-cols-sm-2 row-cols-md-3">
                    <div class="mb-2">
                        <label>Nama Aplikasi</label>
                        <input wire:model="app_name" id="app_name" type="text"
                            class="form-control @error('app_name') is-invalid @enderror">
                        @error('app_name')
                            <div class="spanerror">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="mb-2">
                        <label>Nama Org</label>
                        <input wire:model="app_org" id="app_org" type="text"
                            class="form-control @error('app_org') is-invalid @enderror">
                        @error('app_org')
                            <div class="spanerror">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="mb-2">
                        <label>Website</label>
                        <input wire:model="app_website" id="app_website" type="text"
                            class="form-control @error('app_website') is-invalid @enderror">
                        @error('app_website')
                            <div class="spanerror">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="mb-2">
                        <label>Tahun</label>
                        <input wire:model="app_year" id="app_year" type="text"
                            onchange="@this.set('app_year', this.value);"
                            class="form-control text-end mask_year @error('app_year') is-invalid @enderror">
                        @error('app_year')
                            <div class="spanerror">{{ $message }}</div>
                        @enderror
                    </div>

                </div>


                <div class="row row-cols-1 row-cols-sm-2 row-cols-md-3">

                    <div class="mb-2" x-data="{ uploading: false, progress: 0 }" x-on:livewire-upload-start="uploading = true"
                        x-on:livewire-upload-finish="uploading = false" x-on:livewire-upload-cancel="uploading = false"
                        x-on:livewire-upload-error="uploading = false"
                        x-on:livewire-upload-progress="progress = $event.detail.progress">

                        <label>Logo Light</label>
                        <input type="file" wire:model="app_logo_upload" id="app_logo_upload"
                            class="form-control @error('app_logo_upload') is-invalid @enderror" type="file"
                            accept=".jpg, .jpeg, .png">
                        @error('app_logo_upload')
                            <div class="spanerror">{{ $message }}</div>
                        @enderror

                        <!-- Progress Bar -->
                        <div class="text-center" x-show="uploading">
                            <progress max="100" x-bind:value="progress"></progress>
                        </div>
                        <div class="mt-2 text-center">
                            @if ($app_logo_upload)
                                <img src="{{ $app_logo_upload->temporaryUrl() }}" class="card-img"
                                    style="width: 100px !important; height: 100px !important;">

                                <div class="mt-2">
                                    <button type="button" class="btn btn-danger btn-sm rounded-1"
                                        wire:click="cancel_upload('app_logo_upload')">Cancel</button>
                                </div>
                            @else
                                <img id="vwimage_app_logo" class="card-img"
                                    src="{{ asset($app_logo) }}?{{ now()->timestamp }}" alt=""
                                    style="width: 100px !important; height: 100px !important;">
                            @endif
                        </div>
                    </div>

                    <div class="mb-2" x-data="{ uploading: false, progress: 0 }" x-on:livewire-upload-start="uploading = true"
                        x-on:livewire-upload-finish="uploading = false" x-on:livewire-upload-cancel="uploading = false"
                        x-on:livewire-upload-error="uploading = false"
                        x-on:livewire-upload-progress="progress = $event.detail.progress">

                        <label>Logo Dark</label>
                        <input type="file" wire:model="app_logo_dark_upload" id="app_logo_dark_upload"
                            class="form-control @error('app_logo_dark_upload') is-invalid @enderror" type="file"
                            accept=".jpg, .jpeg, .png">
                        @error('app_logo_dark_upload')
                            <div class="spanerror">{{ $message }}</div>
                        @enderror

                        <!-- Progress Bar -->
                        <div class="text-center" x-show="uploading">
                            <progress max="100" x-bind:value="progress"></progress>
                        </div>

                        <div class="mt-2 text-center">
                            @if ($app_logo_dark_upload)
                                <img src="{{ $app_logo_dark_upload->temporaryUrl() }}" class="card-img"
                                    style="width: 100px !important; height: 100px !important;">

                                <div class="mt-2">
                                    <button type="button" class="btn btn-danger btn-sm rounded-1"
                                        wire:click="cancel_upload('app_logo_dark_upload')">Cancel</button>
                                </div>
                            @else
                                <img id="vwimage_app_logo_dark" class="card-img"
                                    src="{{ asset($app_logo_dark) }}?{{ now()->timestamp }}" alt=""
                                    style="width: 100px !important; height: 100px !important;">
                            @endif
                        </div>
                    </div>

                </div>
            </form>
        </div>
    </div>
</div>
