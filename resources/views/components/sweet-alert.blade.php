<div x-data="{ open: false }" x-show="open"
    @sweet-alert.window="
    Swal.fire({
    position: 'center',
    timer: 3000,
    showConfirmButton: false,
    icon: event.detail.icon,
    title: event.detail.title,
    text: event.detail.text,
   });
">
</div>
