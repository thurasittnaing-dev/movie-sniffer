<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>CM-Sniffer</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.3.0/css/bootstrap-grid.min.css"
        integrity="sha512-EAgFb1TGFSRh1CCsDotrqJMqB2D+FLCOXAJTE16Ajphi73gQmfJS/LNl6AsjDqDht6Ls7Qr1KWsrJxyttEkxIA=="
        crossorigin="anonymous" referrerpolicy="no-referrer" />
    <link rel="stylesheet" href="https://site-assets.fontawesome.com/releases/v6.4.0/css/all.css">
    <link rel="stylesheet" href="{{ asset('css/global.css') }}">
    <style>
        body {
            width: 100vw;
            height: 100vh;
            overflow: hidden;
            margin: 0;
            padding: 0;
            display: flex;
            justify-content: center;
            align-items: center;
            background-color: #fff;
        }

        .left {
            background-color: #fff;
            width: 50vw;
            height: 100vh;
            display: flex;
            justify-content: center;
            flex-direction: column;
            align-items: center;
        }

        .left span {
            opacity: 0.3;
        }

        .myform {
            padding: 0.5rem 1rem;
            border-radius: 0.35rem;
            border: 0.6px solid rgba(0, 0, 0, 0.5);
            outline: none;
            width: 15vw;
            font-size: 16px;
        }

        .right {
            background-color: #8BC6EC;
            background-image: linear-gradient(135deg, #8BC6EC 0%, #9599E2 100%);
            width: 50vw;
            height: 100vh;
            overflow: hidden;
            position: relative;
            /* background-image: url('https://finance.zohocorp.com/wp-content/uploads/2019/01/payment-service-providers-1-1024x512.png');
            background-repeat: no-repeat;
            background-size: cover; */
        }

        .errormessage {
            margin-top: 0.25rem;
            color: red;
            opacity: 0.7;
            font-size: 12px;
        }

        input::-webkit-input-placeholder {
            color: black;
            opacity: 0.2;
        }

        .img {
            width: 100%;
            height: 100%;
            object-fit: cover;
        }

        #backdrop {
            width: 100%;
            height: 100%;
            background-color: black;
            position: absolute;
            top: 0;
            right: 0;
            opacity: 0.3;
        }

        .mytitle {
            font-size: 1.35rem;
            user-select: none;
        }

        .loginbtn {
            width: 100%;
            padding: 0.65rem 1rem;
            border: none;
            color: #fff;
            cursor: pointer;
            border-radius: 0.25rem;
        }
    </style>
</head>

<body>
    @php($login_url = View::getSection('login_url') ?? config('adminlte.login_url', 'login'))
    @php($register_url = View::getSection('register_url') ?? config('adminlte.register_url', 'register'))
    @php($password_reset_url = View::getSection('password_reset_url') ?? config('adminlte.password_reset_url', 'password/reset'))

    @if (config('adminlte.use_route_url', false))
        @php($login_url = $login_url ? route($login_url) : '')
        @php($register_url = $register_url ? route($register_url) : '')
        @php($password_reset_url = $password_reset_url ? route($password_reset_url) : '')
    @else
        @php($login_url = $login_url ? url($login_url) : '')
        @php($register_url = $register_url ? url($register_url) : '')
        @php($password_reset_url = $password_reset_url ? url($password_reset_url) : '')
    @endif
    <div class="wrapper">
        <div class="d-flex">
            <div class="left">
                <div class="text text-dark mytitle">CM Sniffer</div>
                <div>
                    <span class="text-muted"><small style="font-size: 12px;">login here </small></span>
                </div>

                <div>
                    <form action="{{ $login_url }}" method="POST" class="mt-3" autocomplete="off">
                        @csrf
                        <div class="form-group">
                            <input type="email" name="email"
                                class="form-control myform @error('email') is-invalid @enderror"
                                value="{{ old('email') }}" placeholder="Enter your login email" autofocus
                                autocomplete="off">
                        </div>

                        <div class="form-group mt-3">
                            <input type="password" name="password"
                                class="form-control myform @error('password') is-invalid @enderror"
                                placeholder="Type your password">
                            @error('email')
                                <div class="errormessage">{{ $message }}</div>
                            @enderror
                            @error('password')
                                <div class="errormessage">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="form-group mt-3">
                            <button type="submit" class="btn loginbtn btn-theme bg-theme">
                                <i class="fa-solid fa-right-to-bracket"></i> Login
                            </button>
                        </div>
                    </form>
                </div>
            </div>
            <div class="right">
                <img class="img" src="https://netstorage-tuko.akamaized.net/images/64e85b7196e221e3.jpg"
                    alt="">
                <div id="backdrop"></div>
            </div>
        </div>
    </div>

    <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.3.0/js/bootstrap.min.js"
        integrity="sha512-3dZ9wIrMMij8rOH7X3kLfXAzwtcHpuYpEgQg1OA4QAob1e81H8ntUQmQm3pBudqIoySO5j0tHN4ENzA6+n2r4w=="
        crossorigin="anonymous" referrerpolicy="no-referrer"></script>
</body>

</html>
