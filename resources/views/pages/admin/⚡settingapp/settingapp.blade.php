<div>
    <div class="card">
        <div class="card-body">

            <ul class="nav nav-tabs" role="tablist" wire:ignore>
                <li class="nav-item">
                    <a class="nav-link {{ $activeTab === 'tab1' ? 'active' : '' }}" data-bs-toggle="tab" href="#tab1"
                        role="tab" wire:click="setTab('tab1')">
                        <span>Setting</span>
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link {{ $activeTab === 'tab2' ? 'active' : '' }}" data-bs-toggle="tab" href="#tab2"
                        role="tab" wire:click="setTab('tab2')">
                        <span>Database</span>
                    </a>
                </li>
            </ul>

            <div class="tab-content" wire:ignore.self>
                <div class="tab-pane mt-4 {{ $activeTab === 'tab1' ? 'active' : '' }}" id="tab1" role="tabpanel">

                    <div wire:show="showTable" wire:cloak>
                        <div class="p-3 mb-4">
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

                                    <div class="mb-2" x-data="{ uploading: false, progress: 0 }"
                                        x-on:livewire-upload-start="uploading = true"
                                        x-on:livewire-upload-finish="uploading = false"
                                        x-on:livewire-upload-cancel="uploading = false"
                                        x-on:livewire-upload-error="uploading = false"
                                        x-on:livewire-upload-progress="progress = $event.detail.progress">

                                        <label>Logo Light</label>
                                        <input type="file" wire:model="app_logo_upload" id="app_logo_upload"
                                            class="form-control @error('app_logo_upload') is-invalid @enderror"
                                            type="file" accept=".jpg, .jpeg, .png">
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

                                    <div class="mb-2" x-data="{ uploading: false, progress: 0 }"
                                        x-on:livewire-upload-start="uploading = true"
                                        x-on:livewire-upload-finish="uploading = false"
                                        x-on:livewire-upload-cancel="uploading = false"
                                        x-on:livewire-upload-error="uploading = false"
                                        x-on:livewire-upload-progress="progress = $event.detail.progress">

                                        <label>Logo Dark</label>
                                        <input type="file" wire:model="app_logo_dark_upload"
                                            id="app_logo_dark_upload"
                                            class="form-control @error('app_logo_dark_upload') is-invalid @enderror"
                                            type="file" accept=".jpg, .jpeg, .png">
                                        @error('app_logo_dark_upload')
                                            <div class="spanerror">{{ $message }}</div>
                                        @enderror

                                        <!-- Progress Bar -->
                                        <div class="text-center" x-show="uploading">
                                            <progress max="100" x-bind:value="progress"></progress>
                                        </div>

                                        <div class="mt-2 text-center">
                                            @if ($app_logo_dark_upload)
                                                <img src="{{ $app_logo_dark_upload->temporaryUrl() }}"
                                                    class="card-img"
                                                    style="width: 100px !important; height: 100px !important;">

                                                <div class="mt-2">
                                                    <button type="button" class="btn btn-danger btn-sm rounded-1"
                                                        wire:click="cancel_upload('app_logo_dark_upload')">Cancel</button>
                                                </div>
                                            @else
                                                <img id="vwimage_app_logo_dark" class="card-img"
                                                    src="{{ asset($app_logo_dark) }}?{{ now()->timestamp }}"
                                                    alt=""
                                                    style="width: 100px !important; height: 100px !important;">
                                            @endif
                                        </div>
                                    </div>

                                </div>
                            </form>
                        </div>
                    </div>
                </div>

                <div class="tab-pane mt-4 {{ $activeTab === 'tab2' ? 'active' : '' }}" id="tab2"
                    role="tabpanel">
                    <div wire:show="showTable" wire:cloak>
                        <div class="p-3 mb-2">
                            <button type="button" class="btn btn-primary rounded-1" wire:click='backup_db'
                                onclick="loading_spin();" wire:loading.attr='disabled'>Backup
                                Database</button>
                        </div>

                        <div class="p-3 mb-4">
                            @include('components.template.tb-filter', [
                                'no_button_add' => '1',
                                'no_button_status' => '1',
                                'no_button_export' => '1',
                                'no_search' => '1',
                            ])
                            <div class="row divtable">
                                <table id="tbindex_dbbackup" class="table tbview main-table table-hover ">
                                    <thead class="fw-medium">
                                        <tr>
                                            <th class="col-hide">id</th>
                                            <th width="1%">No</th>
                                            <th>Tanggal</th>
                                            <th>Backup Database</th>
                                            <th class="last-col sticky-col" width="5%">#</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @if ($activeTab === 'tab2')
                                            @forelse ($data_rows as $li_data)
                                                <tr>
                                                    <td>{{ $loop->iteration }}</td>
                                                    <td>{{ $li_data['timestamp'] }}</td>
                                                    <td>{{ basename($li_data['path']) }}</td>
                                                    <td>
                                                        <div class="btn-group btn-group-sm d-flex justify-content-center btn_index gap-1"
                                                            id="baction">
                                                            <button wire:click="download_db('{{ $li_data['path'] }}')"
                                                                wire:loading.attr='disabled' id="tbdownload"
                                                                class="btn btn-info rounded-1 btn_index_download"
                                                                data-toggle="tooltip" data-placement="bottom"
                                                                title="Download File">

                                                                <span wire:loading.remove
                                                                    wire:target="download_db('{{ $li_data['path'] }}')"><i
                                                                        class="ti ti-download fs-1"></i></span>
                                                                <span wire:loading
                                                                    wire:target="download_db('{{ $li_data['path'] }}')">Downloading...</span>
                                                            </button>

                                                        </div>
                                                    </td>
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
                </div>
            </div>


        </div>
    </div>
</div>
