<?php

use Livewire\Component;
use Livewire\Attributes\On;

new class extends Component {
    public $data_topbar;

    public $showLight, $showDark;

    #[On('dp-update-logo-topbar')]
    #[On('dp-update-user-name')]
    public function mount()
    {
        $this->data_topbar = help_data_auth_user();

        if (session('ly_theme') == 'light' || session()->has('ly_theme') == false) {
            $this->showLight = false;
            $this->showDark = true;
        } else {
            $this->showLight = true;
            $this->showDark = false;
        }
    }

    // public function ly_theme($value)
    // {
    //     session()->put('ly_theme', $value);
    //     // $this->dispatch('dp-update-logo-sidebar');
    // }

    public function click_theme($value)
    {
        session()->put('ly_theme', $value);
        if ($value == 'light') {
            $this->showLight = false;
            $this->showDark = true;
        } else {
            $this->showLight = true;
            $this->showDark = false;
        }

        $this->dispatch('dp-update-logo-sidebar');
    }
};
?>
<div>
    <!--  Header Start -->
    <header class="topbar">
        <div class="with-vertical"><!-- ---------------------------------- -->
            <!-- Start Vertical Layout Header -->
            <!-- ---------------------------------- -->
            <nav class="navbar navbar-expand-lg p-0">
                <ul class="navbar-nav">
                    <li class="nav-item">
                        <a class="nav-link sidebartoggler nav-icon-hover" id="headerCollapse" href="javascript:void(0)">
                            <div class="nav-icon-hover-bg rounded-circle ">
                                <iconify-icon icon="solar:list-bold-duotone" class="fs-7 text-dark"></iconify-icon>
                            </div>
                        </a>
                    </li>
                </ul>

                <div class="d-block d-lg-none">
                    <div class="d-flex text-nowrap">
                        <div class="div-light-logo align-content-center" wire:show="showDark" wire:cloak>
                            <div style="width: 35px; height: 35px;">
                                <img src="/{{ help_setapp('app_logo') }}?{{ now()->timestamp }}"
                                    class="img-fluid rounded-1" alt="Logo-light">
                            </div>
                        </div>
                        <div class="div-dark-logo align-content-center" wire:show="showLight" wire:cloak>
                            <div style="width: 35px; height: 35px;">
                                <img src="/{{ help_setapp('app_logo_dark') }}?{{ now()->timestamp }}"
                                    class="img-fluid rounded-1" alt="Logo-Dark">
                            </div>
                        </div>
                    </div>
                </div>
                <a class="navbar-toggler nav-icon-hover p-0 border-0" href="javascript:void(0)"
                    data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav"
                    aria-expanded="false" aria-label="Toggle navigation">
                    <span class="p-2">
                        <i class="ti ti-dots fs-7"></i>
                    </span>
                </a>
                <div class="collapse navbar-collapse justify-content-end" id="navbarNav" wire:ignore>
                    <div class="d-flex align-items-center justify-content-between">
                        <ul class="navbar-nav flex-row ms-auto align-items-center justify-content-center">
                            <li class="nav-item dropdown">
                                <a class="nav-link position-relative ms-6" href="javascript:void(0)" id="drop1"
                                    data-bs-toggle="dropdown" aria-expanded="false">
                                    <div class="d-flex align-items-center flex-shrink-0">
                                        <div class="user-profile me-sm-3 me-2">
                                            <img src="/{{ $data_topbar->image }}" width="45" height="45"
                                                class="rounded-circle" alt="userprofile"
                                                onerror="this.onerror=null;this.src='/assets/images/noimage.png';">
                                        </div>
                                        <span class="d-sm-none d-block"><iconify-icon
                                                icon="solar:alt-arrow-down-line-duotone"></iconify-icon></span>

                                        <div class="d-none d-sm-block">
                                            <h6 class="fw-bold fs-4 mb-1 profile-name">{{ $data_topbar->role }}
                                            </h6>
                                            <p class="fs-3 lh-base mb-0 profile-subtext">
                                                {{ $data_topbar->name }}</p>
                                        </div>
                                    </div>
                                </a>
                                <div class="dropdown-menu content-dd dropdown-menu-end dropdown-menu-animate-up"
                                    aria-labelledby="drop1">
                                    <div class="profile-dropdown position-relative" data-simplebar>
                                        <div class="d-flex align-items-center justify-content-between pt-3 px-7">
                                            <h3 class="mb-0 fs-5">User Profile</h3>
                                            <button type="button" class="border-0 bg-transparent" aria-label="Close">
                                                <iconify-icon icon="solar:close-circle-line-duotone"
                                                    class="fs-7 text-muted"></iconify-icon>
                                            </button>
                                        </div>

                                        <div class="d-flex align-items-center mx-7 py-9 border-bottom popup-profile">
                                            <img src="/{{ $data_topbar->image }}" alt="user" width="90"
                                                class="rounded-circle"
                                                onerror="this.onerror=null;this.src='/assets/images/noimage.png';" />
                                            <div class="ms-4 text-akun">
                                                <h4 class="mb-0 fs-5 fw-normal">{{ $data_topbar->name }}</h4>
                                                <span class="text-muted">{{ $data_topbar->role }}</span>
                                                <p class="text-muted mb-0 mt-1 d-flex align-items-center">
                                                    <iconify-icon icon="solar:mailbox-line-duotone"
                                                        class="fs-4 me-1"></iconify-icon>
                                                    {{ $data_topbar->email }}
                                                </p>
                                            </div>
                                        </div>

                                        <div class="message-body">
                                            <a wire:navigate href="/profile"
                                                class=" dropdown-item px-7 d-flex align-items-center py-6">
                                                <span
                                                    class="btn px-3 py-2 bg-info-subtle rounded-1 text-info shadow-none">
                                                    <iconify-icon icon="iconoir:profile-circle"
                                                        class="fs-7"></iconify-icon>
                                                </span>
                                                <div class="w-75 d-inline-block v-middle ps-3 ms-1">
                                                    <h5 class="mb-0 mt-1 fs-4 fw-normal">
                                                        My Profile
                                                    </h5>
                                                    <span
                                                        class="fs-3 text-nowrap d-block fw-normal mt-1 text-muted">Account
                                                        Settings</span>
                                                </div>
                                            </a>
                                        </div>

                                        <div class="py-6 px-7 mb-1">
                                            <a wire:navigate href="/logout" class="btn btn-primary w-100 btn_to_load"
                                                data-bs-placement="top" data-bs-title="Logout"
                                                x-on:click="loading_alert()">Log Out</a>
                                        </div>


                                    </div>
                                </div>
                            </li>
                            <li class="nav-item">
                                <button wire:click="click_theme('light')" wire:show="showLight" wire:cloak
                                    class="nav-link nav-icon-hover sun light-layout" data-name="light">
                                    <iconify-icon icon="solar:sun-2-line-duotone" class="sun fs-7"></iconify-icon>
                                </button>

                                <button wire:click="click_theme('dark')"
                                    class="nav-link nav-icon-hover moon dark-layout" wire:show="showDark" wire:cloak
                                    data-name="dark">
                                    <iconify-icon icon="solar:moon-line-duotone" class="moon fs-7"></iconify-icon>
                                </button>
                            </li>
                            <!-- ------------------------------- -->
                            <!-- end profile Dropdown -->
                            <!-- ------------------------------- -->
                        </ul>
                    </div>
                </div>
            </nav>
            <!-- ---------------------------------- -->
            <!-- End Vertical Layout Header -->
            <!-- ---------------------------------- -->

            <!-- ------------------------------- -->
            <!-- apps Dropdown in Small screen -->
            <!-- ------------------------------- -->
            <!--  Mobilenavbar -->

        </div>

    </header>
    <!--  Header End -->
    <div class="card shadow-none position-relative overflow-hidden mb-4">
        <div class="card-body d-flex align-items-center justify-content-between p-4">
            <h5 class="fw-semibold mb-0"><span
                    class="text-muted text-decoration-none fs-3">{{ session('submenu_nama') }}
                </span>
            </h5>
            <nav aria-label="breadcrumb">
                <ol class="d-flex justify-content-end breadcrumb mb-0">
                    <li class="breadcrumb-item text-muted text-decoration-none text-menu-group1">
                        {{ session('menu_nama') }}
                    </li>

                    <li class="breadcrumb-item text-menu-group2" aria-current="page">{{ session('submenu_nama') }}
                    </li>
                </ol>
            </nav>
        </div>
    </div>
</div>
