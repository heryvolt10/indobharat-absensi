<?php

use Livewire\Component;

new class extends Component {

    public function mount()
    {
        help_update_sess_submenu(2);
    }

    public function saveData()
    {
        // ... perform your logic (e.g., saving to database) ...

        // Dispatch a browser event to trigger the success alert
        $this->dispatch('isLoading');
    }
};
