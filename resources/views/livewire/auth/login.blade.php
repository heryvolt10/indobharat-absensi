<div>
    <div id="main-wrapper" class="p-0 auth-customizer-none ">
        <div
            class="position-relative overflow-hidden radial-gradient min-vh-100 d-flex align-items-center justify-content-center">
            <div class="auth-login-shape-box position-relative">
                <div class="d-flex align-items-center justify-content-center w-100 z-1 position-relative">
                    <div class="card auth-card mb-0 mx-3">
                        <div class="card-body">
                            <div class="text-nowrap d-flex justify-content-center w-100">
                                <img class="rounded-1" src="/{{ help_setapp('app_logo') }}" class="rounded" width="150"
                                    alt="Logo_org">
                            </div>
                            <div class="mt-2 mb-4 text-center d-block">
                                <p class="fs-4 mb-0 fw-bold">{{ help_setapp('app_name') }}</p>
                            </div>
                            <div class="mx-2">
                                <form id="frmdata" wire:submit="authenticate" onsubmit="loading_alert()">
                                    <div class="row">
                                        <div class="mb-3">
                                            <div class="input-group">
                                                <input id="name" name="name" type="text" class="form-control"
                                                    placeholder="Email" aria-label="Email" wire:model="email">
                                                <span class="input-group-text"><iconify-icon
                                                        icon="solar:user-circle-line-duotone"
                                                        class="fs-6 "></iconify-icon></span>
                                            </div>
                                            @error('email')
                                                <div id="errname" class="spanerror d-flex">{{ $message }}</div>
                                            @enderror
                                        </div>
                                        <div class="mb-3">
                                            <div class="input-group">
                                                <input id="password" name="password" type="password"
                                                    class="form-control" placeholder="Password" aria-label="Password"
                                                    value="" wire:model="password">
                                                <span class="input-group-text" style="cursor: pointer;"><iconify-icon
                                                        icon="solar:eye-scan-line-duotone"
                                                        class="fs-6 vwpassword"></iconify-icon></span>
                                            </div>
                                            @error('password')
                                                <div id="errname" class="spanerror d-flex">{{ $message }}</div>
                                            @enderror
                                        </div>
                                        <div class="mb-3">
                                            <button class="btn btn-primary w-100 fs-4 rounded-3" type="submit"
                                                wire:loading.attr='disabled' style="width: 100%;">Login</button>
                                        </div>


                                        <div class="text-center mt-lg-5">
                                            <div>
                                                <span class="fs-4 fw-bold">{{ help_setapp('app_org') }}</span>
                                            </div>
                                            <div>
                                                <span class="fs-2">{{ help_setapp('app_website') }}</span>
                                            </div>
                                            <div>
                                                <span class="fs-1">{{ help_setapp('app_year') }}</span>
                                            </div>
                                        </div>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>

            </div>
        </div>

    </div>
</div>

<script>
    $(document).ready(function() {
        $(".vwpassword").on('click', function(event) {
            event.preventDefault();

            if ($('#password').attr("type") == "text") {
                $('#password').attr('type', 'password');
                $('.vwpassword').removeAttr("icon", "solar:key-square-2-line-duotone");
                $('.vwpassword').attr("icon", "solar:eye-scan-line-duotone");

            } else if ($('#password').attr("type") == "password") {
                $('#password').attr('type', 'text');
                $('.vwpassword').removeAttr("icon", "solar:eye-scan-line-duotone");
                $('.vwpassword').attr("icon", "solar:key-square-2-line-duotone");

            }
        });
    });
</script>
