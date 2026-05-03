<?php

use Livewire\Component;
use Livewire\Attributes\On;

new class extends Component {
    // public $data_sidebar_menu, $data_sidebar_submenu;
    public $showLight, $showDark;
    public $url_logoLight, $url_logoDark;

    #[On('dp-update-logo-sidebar')]
    public function mount()
    {
        $this->url_logoLight = help_setapp('app_logo');
        $this->url_logoDark = help_setapp('app_logo_dark');

        if (session('ly_theme') == 'light' || session()->has('ly_theme') == false) {
            $this->showLight = false;
            $this->showDark = true;
        } else {
            $this->showLight = true;
            $this->showDark = false;
        }
    }

    public function render()
    {
        return $this->view([
            'data_sidebar_menu' => help_user_access_menu(),
            'data_sidebar_submenu' => help_user_access_submenu(),
        ]);
    }
};
?>

<div>
    <aside class="left-sidebar with-vertical">
        <!-- ---------------------------------- -->
        <!-- Start Vertical Layout Sidebar -->
        <!-- ---------------------------------- -->
        <div class="brand-logo align-items-center mt-3 ">
            <div class="d-flex justify-content-between">
                <div class="logo-img w-100">
                    <a href="javascript:void(0)">
                        <div class="d-flex justify-content-center mb-2">
                            <div class="d-flex text-nowrap">
                                <div class="div-light-logo align-content-center" wire:show="showDark" wire:cloak>
                                    <img src="/{{ $url_logoLight }}?{{ now()->timestamp }}" class="img-fluid rounded-1"
                                        alt="Logo-light" style="width: 45px; height: 45px;">
                                </div>
                                <div class="div-dark-logo align-content-center" wire:show="showLight" wire:cloak>
                                    <img src="/{{ $url_logoDark }}?{{ now()->timestamp }}" class="img-fluid rounded-1"
                                        alt="Logo-Dark" style="width: 45px; height: 45px;">
                                </div>
                            </div>
                        </div>
                        <div class="d-flex justify-content-center">
                            <div class="logo-title">
                                <div class="" style="overflow-wrap: anywhere;">
                                    <h6 class="text-muted text-decoration-none fs-3">nama org</h6>
                                </div>
                            </div>
                        </div>
                    </a>

                </div>

                <div>
                    <a href="javascript:void(0)"
                        class="sidebartoggler ms-auto text-decoration-none fs-5 d-block d-xl-none">
                        <i class="ti ti-x"></i>
                    </a>
                </div>
            </div>
        </div>

        <div class="scroll-sidebar" data-simplebar wire:ignore>
            <!-- Sidebar navigation-->
            <nav class="sidebar-nav">
                <ul id="sidebarnav" class="mb-0">
                    @foreach ($data_sidebar_menu as $sidebar_menu)
                        <li class="sidebar-item " wire:key='{{ $sidebar_menu->id }}'>
                            <a class="sidebar-link has-arrow primary-hover-bg " href="javascript:void(0)"
                                aria-expanded="false">
                                <span class="aside-icon p-2 bg-success-subtle rounded-1">
                                    <iconify-icon icon="{{ $sidebar_menu->icon }}" class="fs-6"></iconify-icon>
                                </span>
                                <span class="hide-menu ps-1">{{ $sidebar_menu->nama }}</span>
                            </a>
                            <ul aria-expanded="false" class="collapse first-level ">
                                @foreach ($data_sidebar_submenu as $sidebar_submenu)
                                    @if ($sidebar_menu->id == $sidebar_submenu->f_menu)
                                        <li class="sidebar-item" wire:key='{{ $sidebar_submenu->id }}'>
                                            <a wire:navigate id="sidebar_submenu" href="/{{ $sidebar_submenu->url }}"
                                                class="sidebar-link" data-id="{{ $sidebar_submenu->id }}">
                                                <iconify-icon icon="{{ $sidebar_submenu->icon }}"
                                                    class="fs-6 sidebar-subicon"></iconify-icon>
                                                <span class="hide-menu">{{ $sidebar_submenu->nama }}</span>
                                            </a>
                                        </li>
                                    @endif
                                @endforeach
                            </ul>
                        </li>
                    @endforeach
                </ul>
            </nav>
            <!-- End Sidebar navigation -->
        </div>


        <div class=" fixed-profile mx-3 mt-3">
            <div class="card bg-primary-subtle mb-0 shadow-none">
                <div class="card-body p-3">
                    <div class="d-flex align-items-center justify-content-between gap-3">
                        <div class="d-flex align-items-center gap-3">
                            <p class="mb-0">Log Out</p>
                        </div>

                        <a wire:navigate href="/logout" class="position-relative" data-bs-toggle="tooltip"
                            data-bs-placement="top" data-bs-title="Logout" x-on:click="loading_alert()">
                            <iconify-icon icon="solar:logout-line-duotone" class="fs-8"></iconify-icon>
                        </a>
                    </div>
                </div>
            </div>
        </div>

        <!-- ---------------------------------- -->
        <!-- Start Vertical Layout Sidebar -->
        <!-- ---------------------------------- -->
    </aside>
    <!--  Sidebar End -->
</div>
