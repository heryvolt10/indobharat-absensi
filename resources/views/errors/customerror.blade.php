<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title')</title>

    <link rel="shortcut icon" type="image/png" href="{{ help_setapp('app_logo') }}" />
    <link href="https://fonts.googleapis.com/css?family=Fredoka+One" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css?family=Raleway:400,700" rel="stylesheet">
    <link
        href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@200;300;400;500;600;700;800&display=swap"
        rel="stylesheet">
    <style>
        * {
            -webkit-box-sizing: border-box;
            box-sizing: border-box;
        }

        html {
            font-family: "Plus Jakarta Sans", "Poppins", sans-serif;
        }

        body {
            padding: 0;
            margin: 0;
        }


        .page_404 {
            position: relative;
            height: 100vh;
        }

        .page_404 .notfound {
            position: absolute;
            left: 50%;
            top: 50%;
            -webkit-transform: translate(-50%, -50%);
            -ms-transform: translate(-50%, -50%);
            transform: translate(-50%, -50%);
        }

        .notfound {
            width: 100%;
            text-align: center;
            padding: 0px 15px;
        }

        .notfound .status-text {
            position: absolute;
            place-self: center;
            margin-top: -50vh;
        }

        .notfound .status-text h1 {
            font-family: 'Fredoka One', cursive;
            font-size: 168px;
            margin: 0px;
            color: #fb6197;
            text-transform: uppercase;
        }

        .status-message {
            position: absolute;
            margin-top: 140px !important;
            justify-self: center;
        }


        .notfound h2 {
            font-family: 'Raleway', sans-serif;
            font-size: 1rem;
            font-weight: 500;
            color: #000000;
        }

        .button_link {
            position: absolute;
            margin-top: 170px;
            justify-self: center;
        }

        .btn {
            padding: 10px 20px;
            margin: 20px 0;
            display: inline-block;
            font-family: "Plus Jakarta Sans", "Poppins", sans-serif;
        }

        .btn:hover {
            background: #1c7e15;
        }

        .link_404 {
            color: #fff !important;
            background: #39ac31;

        }

        .rounded-1 {
            border-radius: 0.5rem;
        }

        a {
            color: inherit;
            text-decoration: inherit;
        }

        .four_zero_four_bg {
            background: url(https://cdn.dribbble.com/users/285475/screenshots/2083086/dribbble_1.gif) no-repeat;
            background-position: center;
            position: relative;
            min-height: 100vh;
            background-size: auto;

        }

        @media (max-width: 360px) {
            h1 {
                font-size: 100px !important;
            }

            .button_link {
                margin-top: 200px;
            }
        }
    </style>
</head>

<body>
    <section class="page_404">
        <div class="four_zero_four_bg"></div>
        <div class="notfound">
            <div class="status-text">
                <h1>@yield('code')</h1>
            </div>
            <div class="status-message">
                <h2>@yield('message')</h2>
            </div>
            <div class="button_link">
                @if (isset($sess_id))
                    <a href="/{{ help_submenu(submenu_id: 2)->url }}" class="btn link_404 rounded-1">Kembali</a>
                @else
                    <a href="/" class="btn link_404 rounded-1 back_history">Kembali</a>
                @endif
            </div>
        </div>
    </section>
</body>

</html>
