<!doctype html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">
    <meta name="author" content="Mark Otto, Jacob Thornton, and Bootstrap contributors">
    <meta name="generator" content="Hugo 0.83.1">
    <title>blogs</title>
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <link rel="canonical" href="https://getbootstrap.com/docs/5.0/examples/jumbotron/">


    <!-- Bootstrap core CSS -->
    <!--Plugin CSS file with desired skin-->
    <link rel="stylesheet"
          href="https://cdnjs.cloudflare.com/ajax/libs/ion-rangeslider/2.3.1/css/ion.rangeSlider.min.css"/>

    <!--jQuery-->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>

    <!--Plugin JavaScript file-->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/ion-rangeslider/2.3.1/js/ion.rangeSlider.min.js"></script>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.1/dist/css/bootstrap.min.css" rel="stylesheet"
          integrity="sha384-+0n0xVW2eSR5OomGNYDnhzAbDsOXxcvSN1TPprVMTNDbiYZCxYbOOl7+AMvyTG2x" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.1/dist/js/bootstrap.bundle.min.js"
            integrity="sha384-gtEjrD/SeCtmISkJkNUaaKMoLD0//ElJ19smozuHV6z3Iehds+3Ulb9Bn9Plx0x4"
            crossorigin="anonymous"></script>

    <style>
        .container {
            background: white;
        }

        .avatar {
            margin: 10px;
            max-width: 80px;
            border: 2px solid black;
        }

        .nickname {
            text-align: center
        }

        .nickname-author {
            font-weight: bold;
        }


        .card {
            border-radius: 0px !important;
            padding: 0px !important;
        }


        .card-avatar {
            margin-top: 5px;
        }

        .dashboard a {
            color: black;
            text-decoration: auto;
        }


        .container {
            background-color: white !important;
            margin: 20px;
            border-radius: 10px;
            min-height: 90vh;
            display: flex;
            flex-direction: column;

        }

        body {
            background-color: #2d3748;
        }

        footer {
            margin-top: 100%;
            cursor: pointer;
            justify-self: flex-end;
        }

        footer {
            margin-top: auto !important;
        }


        body {
            display: flex;
            justify-content: center;
        }


    </style>

    <!-- Favicons -->
    <link rel="apple-touch-icon" href="/docs/5.0/assets/img/favicons/apple-touch-icon.png" sizes="180x180">
    <link rel="icon" href="/docs/5.0/assets/img/favicons/favicon-32x32.png" sizes="32x32" type="image/png">
    <link rel="icon" href="/docs/5.0/assets/img/favicons/favicon-16x16.png" sizes="16x16" type="image/png">
    <link rel="manifest" href="/docs/5.0/assets/img/favicons/manifest.json">
    <link rel="mask-icon" href="/docs/5.0/assets/img/favicons/safari-pinned-tab.svg" color="#7952b3">
    <link rel="icon" href="/docs/5.0/assets/img/favicons/favicon.ico">
    <meta name="theme-color" content="#7952b3">
    <script src="/js/zhsmenu.js"></script>


    <style>
        .bd-placeholder-img {
            font-size: 1.125rem;
            text-anchor: middle;
            -webkit-user-select: none;
            -moz-user-select: none;
            user-select: none;
        }

        @media (min-width: 768px) {
            .bd-placeholder-img-lg {
                font-size: 3.5rem;
            }
        }
    </style>


</head>
<body>

<div class="container py-4">
    <header class="pb-3 mb-4 border-bottom d-flex flex-row justify-content-start">
        <div class="logo">
            <a href="/" class="d-flex align-items-center text-dark text-decoration-none">
                <svg xmlns="http://www.w3.org/2000/svg" width="40" height="32" class="me-2" viewBox="0 0 118 94"
                     role="img"><title>Bootstrap</title>
                    <path fill-rule="evenodd" clip-rule="evenodd"
                          d="M24.509 0c-6.733 0-11.715 5.893-11.492 12.284.214 6.14-.064 14.092-2.066 20.577C8.943 39.365 5.547 43.485 0 44.014v5.972c5.547.529 8.943 4.649 10.951 11.153 2.002 6.485 2.28 14.437 2.066 20.577C12.794 88.106 17.776 94 24.51 94H93.5c6.733 0 11.714-5.893 11.491-12.284-.214-6.14.064-14.092 2.066-20.577 2.009-6.504 5.396-10.624 10.943-11.153v-5.972c-5.547-.529-8.934-4.649-10.943-11.153-2.002-6.484-2.28-14.437-2.066-20.577C105.214 5.894 100.233 0 93.5 0H24.508zM80 57.863C80 66.663 73.436 72 62.543 72H44a2 2 0 01-2-2V24a2 2 0 012-2h18.437c9.083 0 15.044 4.92 15.044 12.474 0 5.302-4.01 10.049-9.119 10.88v.277C75.317 46.394 80 51.21 80 57.863zM60.521 28.34H49.948v14.934h8.905c6.884 0 10.68-2.772 10.68-7.727 0-4.643-3.264-7.207-9.012-7.207zM49.948 49.2v16.458H60.91c7.167 0 10.964-2.876 10.964-8.281 0-5.406-3.903-8.178-11.425-8.178H49.948z"
                          fill="currentColor"></path>
                </svg>
                <span class="fs-4">IBLOCK CMS</span>
            </a>

        </div>
        <style>
            .zhs {
                position: absolute;
                z-index: 100;
                background: transparent;
                display: none;
            }

            .zhs-menu-event:hover .zhs {
                display: block;
            }

            .zhs-menu {
                display: flex;
            }

            .zhs-menu .zhs-menu--items {
                display: inline-flex;
                flex-direction: column;
                background-color: transparent;
            }

            .zhs-menu .zhs-menu--items--item {
                height: 50px;
                margin: 1px;
                transition: color .15s ease-in-out, background-color .15s ease-in-out, border-color .15s ease-in-out;
                border-radius: .25rem;
                padding: .5rem 1rem;
                display: block;
                cursor: pointer;
                color: #fff;
                background-color: #0d6efd;
            }
            .zhs-menu .zhs-menu--items--item a{
                color: white;
                text-decoration: none;
            }
        </style>
        <ul class="d-xl-block d-none nav nav-pills">
            <li class="nav-item zhs-menu-event"><a href="#" class="nav-link">Каталог</a>
                <div class="zhs"></div>
            </li>

        </ul>
        @yield('zhsmenu')

    </header>
    @yield('content')
    <footer class="pt-3 text-muted border-top">
        superwebteam &copy; 2022
    </footer>
</div>
</body>
</html>
