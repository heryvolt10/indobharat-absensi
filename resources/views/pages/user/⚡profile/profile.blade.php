<div>
    <div class="position-relative overflow-hidden">
        <div class="card">
            <div class="card-body pb-0">
                <div class="d-md-flex align-items-center justify-content-between text-center text-md-start">
                    <div class="d-md-flex align-items-center">
                        <div class="rounded-circle position-relative mb-9 mb-md-0 d-inline-block">
                            <img src="{{ help_data_auth_user()->image }}" alt="" class="rounded-circle"
                                width="100" height="100"
                                onerror="this.onerror=null;this.src='/assets/images/noimage.png';">
                            <span
                                class="text-bg-primary rounded-circle text-white d-flex align-items-center justify-content-center position-absolute bottom-0 end-0 p-1 border border-2 border-white"><i
                                    class="ti ti-plus"></i></span>
                        </div>
                        <div class="ms-0 ms-md-3 mb-9 mb-md-0">
                            <div class="d-flex align-items-center justify-content-center justify-content-md-start mb-1">
                                <h4 class="mb-0 fs-7">{{ help_data_auth_user()->name }}</h4>
                            </div>
                            <p class="fs-4 mb-1">{{ help_data_auth_user()->role }}</p>
                            <div class="d-flex align-items-center justify-content-center justify-content-md-start">
                                <span class="bg-success p-1 rounded-circle"></span>
                                <h6 class="mb-0 ms-2">Active</h6>
                            </div>
                        </div>
                    </div>
                </div>
                <ul class="nav nav-pills user-profile-tab mt-4 justify-content-center justify-content-md-start"
                    id="pills-tab" role="tablist">
                    <li class="nav-item me-2 me-md-3" role="presentation">
                        <button wire:click="selectTab('tab1')"
                            class="nav-link position-relative rounded-0 d-flex align-items-center justify-content-center bg-transparent py-6 {{ $activeTab == 'tab1' ? 'active' : '' }}"
                            id="pills-tab1-tab" data-bs-toggle="pill" data-bs-target="#pills-tab1" type="button"
                            role="tab" aria-controls="pills-tab1"
                            aria-selected="{{ $activeTab == 'tab1' ? 'true' : 'false' }}">
                            <i class="fas fa-dashboard me-0 me-md-6  fs-6"></i>
                            <span class="d-none d-md-block">Dashboard</span>
                        </button>
                    </li>

                    <li class="nav-item me-2 me-md-3" role="presentation">
                        <button wire:click="selectTab('tab2')"
                            class="nav-link position-relative rounded-0 d-flex align-items-center justify-content-center bg-transparent py-6 {{ $activeTab == 'tab2' ? 'active' : '' }}"
                            id="pills-tab2-tab" data-bs-toggle="pill" data-bs-target="#pills-tab2" type="button"
                            role="tab" aria-controls="pills-tab2"
                            aria-selected="{{ $activeTab == 'tab2' ? 'true' : 'false' }}">
                            <i class="ti ti-settings me-0 me-md-6  fs-6"></i>
                            <span class="d-none d-md-block">Setting</span>
                        </button>
                    </li>

                </ul>
            </div>
        </div>
    </div>
    <div class="tab-content mx-10" id="pills-tabContent">
        <div class="tab-pane tab1 fade {{ $activeTab == 'tab1' ? 'show active' : '' }}" id="pills-tab1" role="tabpanel"
            aria-labelledby="pills-tab1-tab" tabindex="0">
            {{-- <div class="col-sm-4">
                <div class="card">
                    <div class="card-body p-4">

                        <div class="d-flex align-items-center gap-3">
                            <div class="d-flex align-items-center">
                                <div
                                    class="text-bg-primary rounded-1 d-flex align-items-center justify-content-center p-6">
                                    <i class="ti ti-clipboard-check text-white fs-7"></i>
                                </div>
                            </div>
                            <div class="position-relative w-100">
                                <div class="row align-items-center justify-content-between">
                                    <div class="col-9">
                                        <p class="mb-0 fs-3">Absen yang belum di approve</p>
                                    </div>
                                    <div class="col-3">
                                        <h3 class="mb-0 fs-7">00</h3>
                                    </div>
                                </div>
                            </div>
                        </div>

                    </div>
                </div>
            </div> --}}

        </div>

        <div class="tab-pane tab2 fade {{ $activeTab == 'tab2' ? 'show active' : '' }}" id="pills-tab2" role="tabpanel"
            aria-labelledby="pills-tab2-tab" tabindex="2">

            <div class="card">
                <div class="card-body">
                    <div class="row mb-4">
                        <div class="mb-3 bg-light-subtle rounded-1">
                            <div class="container">
                                <div class="col-form-label ">
                                    <h5>Data User</h5>
                                </div>
                            </div>
                        </div>

                        <form wire:submit.prevent="update" id="frmdata_user" class="frmform" method="POST">
                            @csrf
                            <!-- ---------------------------------------------- button --------------------------------------------- -->
                            <div class="border-bottom p-3 mb-4 d-flex gap-2 btn-group-lg">

                                <button id="btn_save_user" type="submit" wire:loading.attr="disabled"
                                    onclick="loading_alert();" class="btn btn-primary btn_frm btn_frm_save rounded-1"
                                    data-toggle="tooltip" data-placement="bottom" title="Simpan">
                                    <i class="far fa-save"></i>
                                </button>

                            </div>
                            <!-- ---------------------------------------------- button End --------------------------------------------- -->
                            <input type="hidden" class="form-control" id="id" name="id" wire:model='id'>

                            <div class="container d-flex justify-content-center mb-1">
                                <div class="upload_picture-container">
                                    <div class="upload_picture picture_profile mb-2">
                                        @if ($imageNew)
                                            <img src="{{ help_data_auth_user()->image }}" class="upload_picture-src"
                                                id="vwImage" title="">
                                        @elseif ($image && !$errors->has('image'))
                                            <img src="{{ $image->temporaryUrl() }}" class="upload_picture-src"
                                                id="vwImage" title="">
                                        @else
                                            <img src="{{ help_data_auth_user()->image }}" class="upload_picture-src"
                                                id="vwImage" title="">
                                        @endif
                                        <input wire:model='image' type="file" id="image" class="form-control"
                                            accept=".jpg, .jpeg, .png" data-file_types="jpg|jpeg|png">
                                    </div>
                                    <div wire:loading wire:target="image">Uploading...</div>
                                    @error('image')
                                        <div id="errname" class="spanerror d-flex">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                            <div class="d-flex justify-content-center mb-1">
                                <div class="row text-center">
                                    <h6 class="">Upload Foto Profile</h6>
                                    <span class="">Extensi File JPG|JPEG|PNG Ukuran 1x1</span>

                                </div>
                            </div>

                            <div class="container d-flex justify-content-center">
                                <button wire:click="resetImage" type="button" id="resetupload" name="resetupload"
                                    class="btn btn-primary rounded-1" data-toggle="tooltip" data-placement="bottom"
                                    title="Reset Upload"><i class="fa-solid fa-retweet"></i></button>
                            </div>

                            <hr>
                            <div class="row">
                                <div class="col-md-6">
                                    <div class=" row">
                                        <div class="mb-2">
                                            <label>Email</label>
                                            <input wire:model='email' id="email" name="email" type="text"
                                                class="form-control onlyread" readonly>
                                        </div>
                                        <div class="mb-2">
                                            <label>Nama</label>
                                            <input wire:model='name' id="name" name="name" type="text"
                                                class="form-control" value="">
                                            @error('name')
                                                <div id="errname" class="spanerror">{{ $message }}</div>
                                            @enderror
                                        </div>

                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="row">

                                    </div>
                                </div>
                            </div>

                        </form>
                    </div>
                </div>
            </div>

            <div class="card">
                <div class="card-body">

                    <div class="mb-3 bg-light-subtle rounded-1">
                        <div class="container">
                            <div class="col-form-label ">
                                <h5>Ubah Password</h5>
                            </div>
                        </div>
                    </div>

                    <form wire:submit.prevent="updatePassword" id="frmdata_password" class="frmform"
                        method="POST"autocomplete="off">
                        <!-- ---------------------------------------------- button --------------------------------------------- -->
                        <div class="border-bottom p-3 mb-4 d-flex gap-2 btn-group-lg">

                            <button id="btn_save" type="submit" onclick="loading_alert();"
                                class="btn btn-primary btn_frm btn_frm_save rounded-1" data-toggle="tooltip"
                                data-placement="bottom" title="Simpan">
                                <i class="far fa-save"></i>
                            </button>
                        </div>
                        <!-- ---------------------------------------------- button End --------------------------------------------- -->
                        <div class="col-md-6">
                            <div class="mb-2">
                                <label>Password Lama</label>
                                <div class="mb-3">
                                    <div class="input-group">
                                        <input wire:model='password_current' id="password_current" type="password"
                                            class="form-control" value="">
                                        <span class="input-group-text" style="cursor: pointer;"><iconify-icon
                                                icon="solar:eye-scan-line-duotone" class="fs-6 vwpassword"
                                                data-id="password_current"></iconify-icon></span>
                                    </div>
                                    @error('password_current')
                                        <div id="errname" class="spanerror">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                            <div class="mb-2">
                                <label>Password Baru</label>
                                <div class="mb-3">
                                    <div class="input-group">
                                        <input wire:model='password' id="password" type="password"
                                            class="form-control" value="">
                                        <span class="input-group-text" style="cursor: pointer;"><iconify-icon
                                                icon="solar:eye-scan-line-duotone" class="fs-6 vwpassword"
                                                data-id="password"></iconify-icon></span>
                                    </div>
                                    @error('password')
                                        <div id="errname" class="spanerror">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                            <div class="mb-2">
                                <label>Confirm Password Baru</label>
                                <div class="mb-3">
                                    <div class="input-group">
                                        <input wire:model='password_confirmation' id="password_confirmation"
                                            type="password" class="form-control" value="">
                                        <span class="input-group-text" style="cursor: pointer;"><iconify-icon
                                                icon="solar:eye-scan-line-duotone" class="fs-6 vwpassword"
                                                data-id="password_confirmation"></iconify-icon></span>
                                    </div>
                                    @error('password_confirmation')
                                        <div id="errname" class="spanerror">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                        </div>


                    </form>
                </div>
            </div>
        </div>
    </div>


</div>

<script>
    $(".vwpassword").on('click', function(e) {
        e.preventDefault();

        $idData = $(this).data('id');

        if ($('#' + $idData).attr("type") == "text") {
            $('#' + $idData).attr('type', 'password');

            $(this).removeAttr("icon", "solar:key-square-2-line-duotone");
            $(this).attr("icon", "solar:eye-scan-line-duotone");

        } else {
            $('#' + $idData).attr('type', 'text');

            $(this).removeAttr("icon", "solar:eye-scan-line-duotone");
            $(this).attr("icon", "solar:key-square-2-line-duotone");
        }

    });
</script>
