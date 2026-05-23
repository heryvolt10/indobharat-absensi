<div x-data="{ open: false }" x-show="open"
    @sweet-alert-notime.window="
    Swal.fire({
    position: 'center',
    showConfirmButton: true,
    icon: event.detail.icon,
    title: event.detail.title,
    text: event.detail.text,
   });
">
</div>
