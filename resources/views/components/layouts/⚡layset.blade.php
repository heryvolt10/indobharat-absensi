<?php

use Livewire\Component;

new class extends Component {
    public function month() {}

    public function ly_theme($value)
    {
        session()->put('ly_theme', $value);
        $this->dispatch('dp-update-logo-topbar');
        $this->dispatch('dp-update-logo-sidebar');
    }

    public function ly_sidebar($value)
    {
        session()->put('ly_sidebar', $value);
    }

    public function ly_container($value)
    {
        session()->put('ly_container', $value);
    }

    public function ly_card($value)
    {
        session()->put('ly_card', $value);
    }

    public function ly_color($value)
    {
        session()->put('ly_color', $value);
    }
};
?>


<div wire:ignore>
    <button class="btn btn-primary p-2 rounded-circle d-flex align-items-center justify-content-center customizer-btn"
        type="button" data-bs-toggle="offcanvas" data-bs-target="#offcanvasExample" aria-controls="offcanvasExample">
        <i class="icon ti ti-settings fs-7"></i>
    </button>
    <div class="offcanvas customizer offcanvas-end" tabindex="-1" id="offcanvasExample"
        aria-labelledby="offcanvasExampleLabel">
        <div class="d-flex align-items-center justify-content-between p-3 border-bottom">
            <h4 class="offcanvas-title fw-semibold" id="offcanvasExampleLabel">
                Settings
            </h4>
            <button type="button" class="btn-close" data-bs-dismiss="offcanvas" aria-label="Close"></button>
        </div>
        <div class="offcanvas-body" data-simplebar style="height: calc(100vh - 80px)">
            <h6 class="fw-semibold fs-4 mb-2">Theme</h6>
            <div class="d-flex flex-row gap-3 customizer-box" role="group">
                <input type="radio" class="btn-check light-layout ly_button" name="theme-layout" id="light-layout"
                    data-name="light" autocomplete="off" wire:click="ly_theme('light')" />
                <label
                    class="btn p-9 btn-outline-primary label_ly_theme_light {{ session('ly_theme') == 'light' || !session()->has('ly_theme') ? 'pick_set_ly' : '' }}"
                    for="light-layout"><i class="icon ti ti-brightness-up fs-7 me-2"></i>Light</label>

                <input type="radio" class="btn-check dark-layout ly_button" name="theme-layout" id="dark-layout"
                    data-name="dark" autocomplete="off" wire:click="ly_theme('dark')" />
                <label
                    class="btn p-9 btn-outline-primary label_ly_theme_dark {{ session('ly_theme') == 'dark' ? 'pick_set_ly' : '' }}"
                    for="dark-layout"><i class="icon ti ti-moon fs-7 me-2 "></i>Dark</label>
            </div>

            <h6 class="mt-5 fw-semibold fs-4 mb-2">Theme Colors</h6>
            <div class="d-flex flex-row flex-wrap gap-3 customizer-box color-pallete" role="group">
                <input type="radio" class="btn-check" name="color-theme-layout" id="Blue_Theme" autocomplete="off"
                    {{ session('ly_color') == 'Blue_Theme' || !session()->has('ly_color') ? 'checked' : '' }} />
                <label class="btn p-9 btn-outline-primary d-flex align-items-center justify-content-center"
                    onclick="handleColorTheme('Blue_Theme')" for="Blue_Theme" data-bs-toggle="tooltip"
                    data-bs-placement="top" data-bs-title="BLUE_THEME" wire:click="ly_color('Blue_Theme')">
                    <div class="color-box rounded-circle d-flex align-items-center justify-content-center skin-1">
                        <i class="ti ti-check text-white d-flex icon fs-5"></i>
                    </div>
                </label>

                <input type="radio" class="btn-check" name="color-theme-layout" id="Aqua_Theme" autocomplete="off"
                    {{ session('ly_color') == 'Aqua_Theme' ? 'checked' : '' }} />
                <label class="btn p-9 btn-outline-primary d-flex align-items-center justify-content-center"
                    onclick="handleColorTheme('Aqua_Theme')" for="Aqua_Theme" data-bs-toggle="tooltip"
                    data-bs-placement="top" data-bs-title="AQUA_THEME" wire:click="ly_color('Aqua_Theme')">
                    <div class="color-box rounded-circle d-flex align-items-center justify-content-center skin-2">
                        <i class="ti ti-check text-white d-flex icon fs-5"></i>
                    </div>
                </label>

                <input type="radio" class="btn-check" name="color-theme-layout" id="Purple_Theme" autocomplete="off"
                    {{ session('ly_color') == 'Purple_Theme' ? 'checked' : '' }} />
                <label class="btn p-9 btn-outline-primary d-flex align-items-center justify-content-center"
                    onclick="handleColorTheme('Purple_Theme')" for="Purple_Theme" data-bs-toggle="tooltip"
                    data-bs-placement="top" data-bs-title="PURPLE_THEME" wire:click="ly_color('Purple_Theme')">
                    <div class="color-box rounded-circle d-flex align-items-center justify-content-center skin-3">
                        <i class="ti ti-check text-white d-flex icon fs-5"></i>
                    </div>
                </label>

                <input type="radio" class="btn-check" name="color-theme-layout" id="green-theme-layout"
                    autocomplete="off" {{ session('ly_color') == 'Green_Theme' ? 'checked' : '' }} />
                <label class="btn p-9 btn-outline-primary d-flex align-items-center justify-content-center"
                    onclick="handleColorTheme('Green_Theme')" for="green-theme-layout" data-bs-toggle="tooltip"
                    data-bs-placement="top" data-bs-title="GREEN_THEME" wire:click="ly_color('Green_Theme')">
                    <div class="color-box rounded-circle d-flex align-items-center justify-content-center skin-4">
                        <i class="ti ti-check text-white d-flex icon fs-5"></i>
                    </div>
                </label>

                <input type="radio" class="btn-check" name="color-theme-layout" id="cyan-theme-layout"
                    autocomplete="off" {{ session('ly_color') == 'Cyan_Theme' ? 'checked' : '' }} />
                <label class="btn p-9 btn-outline-primary d-flex align-items-center justify-content-center"
                    onclick="handleColorTheme('Cyan_Theme')" for="cyan-theme-layout" data-bs-toggle="tooltip"
                    data-bs-placement="top" data-bs-title="CYAN_THEME" wire:click="ly_color('Cyan_Theme')">
                    <div class="color-box rounded-circle d-flex align-items-center justify-content-center skin-5">
                        <i class="ti ti-check text-white d-flex icon fs-5"></i>
                    </div>
                </label>

                <input type="radio" class="btn-check" name="color-theme-layout" id="orange-theme-layout"
                    autocomplete="off" {{ session('ly_color') == 'Orange_Theme' ? 'checked' : '' }} />
                <label class="btn p-9 btn-outline-primary d-flex align-items-center justify-content-center"
                    onclick="handleColorTheme('Orange_Theme')" for="orange-theme-layout" data-bs-toggle="tooltip"
                    data-bs-placement="top" data-bs-title="ORANGE_THEME" wire:click="ly_color('Orange_Theme')">
                    <div class="color-box rounded-circle d-flex align-items-center justify-content-center skin-6">
                        <i class="ti ti-check text-white d-flex icon fs-5"></i>
                    </div>
                </label>
            </div>

            <h6 class="mt-5 fw-semibold fs-4 mb-2">Container Option</h6>
            <div class="d-flex flex-row gap-3 customizer-box" role="group">

                <input type="radio" class="btn-check ly_button" name="layout" id="full-layout"
                    autocomplete="off" data-name="full" wire:click="ly_container('full')" />
                <label
                    class="btn p-9 btn-outline-primary label_ly_container_full {{ session('ly_container') == 'full' || !session()->has('ly_container') ? 'pick_set_ly' : '' }}"
                    for="full-layout"><i class="icon ti ti-layout-distribute-horizontal fs-7 me-2"></i>Full</label>

                <input type="radio" class="btn-check ly_button" name="layout" id="boxed-layout"
                    autocomplete="off" data-name="boxed" wire:click="ly_container('boxed')" />
                <label
                    class="btn p-9 btn-outline-primary label_ly_container_boxed {{ session('ly_container') == 'boxed' ? 'pick_set_ly' : '' }}"
                    for="boxed-layout"><i class="icon ti ti-layout-distribute-vertical fs-7 me-2"></i>Boxed</label>


            </div>

            <h6 class="fw-semibold fs-4 mb-2 mt-5">Sidebar Type</h6>
            <div class="d-flex flex-row gap-3 customizer-box" role="group">
                <a href="javascript:void(0)" class="fullsidebar">
                    <input type="radio" class="btn-check ly_button" name="sidebar-type" id="full-sidebar"
                        autocomplete="off" data-name="full_sidebar" wire:click="ly_sidebar('full')" />
                    <label
                        class="btn p-9 btn-outline-primary label_ly_sidebar_full {{ session('ly_sidebar') == 'full' || !session()->has('ly_sidebar') ? 'pick_set_ly' : '' }}"
                        for="full-sidebar"><i class="icon ti ti-layout-sidebar-right fs-7 me-2"></i>Full</label>
                </a>
                <div>
                    <input type="radio" class="btn-check ly_button" name="sidebar-type" id="mini-sidebar"
                        data-name="mini_sidebar" autocomplete="off" wire:click="ly_sidebar('mini-sidebar')" />
                    <label
                        class="btn p-9 btn-outline-primary label_ly_sidebar_mini {{ session('ly_sidebar') == 'mini-sidebar' ? 'pick_set_ly' : '' }}"
                        for="mini-sidebar"><i class="icon ti ti-layout-sidebar fs-7 me-2"></i>Collapse</label>
                </div>
            </div>

            <h6 class="mt-5 fw-semibold fs-4 mb-2">Card With</h6>
            <div class="d-flex flex-row gap-3 customizer-box" role="group">
                <input type="radio" class="btn-check" name="card-layout" id="card-with-border" autocomplete="off"
                    wire:click="ly_card('border')" />
                <label
                    class="btn p-9 btn-outline-primary label_ly_card_border {{ session('ly_card') == 'border' || !session()->has('ly_card') ? 'pick_set_ly' : '' }}"
                    for="card-with-border"><i class="icon ti ti-border-outer fs-7 me-2"></i>Border</label>

                <input type="radio" class="btn-check" name="card-layout" id="card-without-border"
                    autocomplete="off" wire:click="ly_card('shadow')" />
                <label
                    class="btn p-9 btn-outline-primary label_ly_card_shadow {{ session('ly_card') == 'shadow' ? 'pick_set_ly' : '' }}"
                    for="card-without-border"><i class="icon ti ti-border-none fs-7 me-2"></i>Shadow</label>
            </div>
        </div>
    </div>
</div>
