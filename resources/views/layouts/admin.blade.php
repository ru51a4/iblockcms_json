<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8"/>
    <meta http-equiv="X-UA-Compatible" content="IE=edge"/>
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no"/>

    <!-- page meta -->
    <meta name="description" content="Minimalistic Admin Panel built with Bootstrap 5"/>
    <meta name="author" content="LeKoala"/>
    <meta name="keywords" content="bootstrap, bootstrap 5, admin, panel, template, minimalistic"/>

    <!-- performance -->
    <link rel="preconnect" href="https://fonts.googleapis.com"/>
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin/>
    <script src="//ajax.googleapis.com/ajax/libs/jquery/1.8/jquery.min.js"></script>

    <!-- page title & icon -->
    <link
        rel="icon"
        type="image/svg+xml"
        href="data:image/svg+xml,<svg xmlns=%22http://www.w3.org/2000/svg%22 width=%22256%22 height=%22256%22 viewBox=%220 0 100 100%22><text x=%2250%%22 y=%2252%%22 dominant-baseline=%22central%22 text-anchor=%22middle%22 font-size=%22120%22>💠</text></svg>"
    />
    <title>Admini</title>

    <!-- styles -->
    <link href="/css/admini.min.css" rel="stylesheet"/>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;600&display=swap" rel="stylesheet"/>
    <style>
        .scroller {
            padding: 10px;
        }
    </style>
    <!-- icons -->
    <script>
        window.LastIcon = {
            types: {
                material: "twotone",
            },
            defaultSet: "material",
            fonts: ["material"],
        };
    </script>
    <script src="/js/last-icon.min.js"></script>
    <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet"/>
    <link href="https://fonts.googleapis.com/icon?family=Material+Icons+Two+Tone" rel="stylesheet"/>

    <!-- scripts -->
    <script
        src="https://cdn.jsdelivr.net/gh/lekoala/nomodule-browser-warning.js/nomodule-browser-warning.min.js"
        nomodule
        defer
        id="nomodule-browser-warning"
    ></script>
    <script type="module" src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script type="module" src="/js/admini.min.js"></script>
    <script type="module">
        let sel = document.getElementById("sidebar-selector");
       /* sel.addEventListener("change", (ev) => {
            let color = sel.selectedOptions[0].style.backgroundColor;
            if (color) {
                document.querySelector(".sidebar-brand").style.backgroundColor = color;
            } else {
                document.querySelector(".sidebar-brand").style.backgroundColor = "inherit";
            }
        });*/
    </script>
    <script type="module">window.admini.init(); // this should go last</script>
</head>

<!-- minimenu class should be applied on render -->

<body>
<div class="wrapper">
    <aside id="sidebar" class="sidebar" data-bs-scroll="true">
        <a class="sidebar-brand" href="/admin">
          <span class="sidebar-brand-icon">
          </span>
            <span class="sidebar-brand-title">IBLOCK CMS</span>
        </a>

        <!-- optional selector -->
    {{--<select name="" id="sidebar-selector" class="form-select">
        <option value="">Main site</option>
        <option value="" style="background: crimson; color: #fff">This site</option>
        <option value="">That site</option>
        <option value="">Other site with a long name&nbsp;&nbsp;</option>
        <!-- cheap trick to add space after -->
    </select>
--}}
    <!-- optional dropdown or profile -->
        @if(auth()->user())
            <div class="sidebar-profile dropdown">
                <div class="sidebar-profile-name dropdown-toggle">{{auth()->user()->email}} </div>
                <div class="sidebar-profile-subtitle">Administrator</div>
                </button>

                <div class="dropdown-menu">
                    <a class="dropdown-item" href="/admin/logout">Log out</a>
                </div>
            </div>
    @endif

    <!-- sidebar-content -->
        <div class="sidebar-content scroller">
            <ul class="sidebar-nav">
                <li class="sidebar-nav-header">UI</li>

                <li class="sidebar-item active">
                    <a class="sidebar-link" href="/admin">
                        <span>Информационные блоки</span> </a>
                </li>

                <!-- this will collapse to a button when sidebar is collapsed -->

        </div>
        <!-- /sidebar-content -->

        <!-- sidebar-footer -->
        <div class="sidebar-footer">
            <button class="btn btn-default sidebar-toggle js-sidebar-toggle">
                <l-i name="menu_open"></l-i>
            </button>
            <div class="dropup">
                <button class="btn btn-default" id="help-dropdown-btn" data-bs-toggle="dropdown">
                    <l-i name="help_outline"></l-i>
                </button>
                <ul class="dropdown-menu dropdown-menu-dark" aria-labelledby="help-dropdown-btn">
                    <li><a class="dropdown-item" href="help.html">Help</a></li>
                    <li><a class="dropdown-item" href="faq.html">FAQ</a></li>
                    <li>
                        <hr class="dropdown-divider"/>
                    </li>
                    <p class="m-3 mb-0">
                        <small>Built with Admini</small>
                    </p>
                </ul>
            </div>
        </div>
        <!-- /sidebar-footer -->
    </aside>

    <main class="main">
        <header class="main-header">
            <div class="main-header-sidebar">
                <button
                    type="button"
                    class="btn btn-primary btn-flex btn-square rounded-0"
                    data-bs-toggle="offcanvas"
                    data-bs-target="#sidebar"
                    aria-controls="sidebar"
                >
                    <l-i name="menu"></l-i>
                </button>
            </div>
            <div class="main-header-info">
                <nav aria-label="breadcrumb">
                    <div class="breadcrumb">
                        <li class="breadcrumb-item active" aria-current="page">Dashboard</li>
                    </div>
                </nav>
            </div>
            <div class="main-header-nav">
                <nav class="nav">
                    <div class="nav-item">
                        <div class="dropdown dropleft me-1">
                            <ul class="dropdown-menu dropdown-menu-end dropdown-menu-lg py-0"
                                aria-labelledby="notificationMenuLink">
                                <div class="dropdown-menu-header">
                                    <h6>Notifications</h6>
                                    <a href="">Mark as read</a>
                                </div>
                                <div class="list-group">
                                    <a href="#" class="list-group-item list-group-item-action">
                                        <div class="row g-0 align-items-center">
                                            <div class="col-2">
                                                <l-i name="info" class="text-danger"></l-i>
                                            </div>
                                            <div class="col-10">
                                                <div class="d-flex w-100 justify-content-between">
                                                    <h5 class="mb-1">Something bad happened</h5>
                                                    <small>3 days ago</small>
                                                </div>
                                                <p class="mb-1">Some placeholder content in a paragraph.</p>
                                                <small>And some small print.</small>
                                            </div>
                                        </div>
                                    </a>
                                    <a href="#" class="list-group-item list-group-item-action">
                                        <div class="d-flex w-100 justify-content-between">
                                            <h5 class="mb-1">List group item heading</h5>
                                            <small class="text-muted">3 days ago</small>
                                        </div>
                                        <p class="mb-1">Some placeholder content in a paragraph.</p>
                                        <small class="text-muted">And some muted small print.</small>
                                    </a>
                                    <a href="#" class="list-group-item list-group-item-action">
                                        <div class="d-flex w-100 justify-content-between">
                                            <h5 class="mb-1">List group item heading</h5>
                                            <small class="text-muted">3 days ago</small>
                                        </div>
                                        <p class="mb-1">Some placeholder content in a paragraph.</p>
                                        <small class="text-muted">And some muted small print.</small>
                                    </a>
                                </div>
                                <a href="#" class="dropdown-menu-footer">See all notifications</a>
                            </ul>
                        </div>
                    </div>
                </nav>
            </div>
        </header>
        <section class="scroller">
            @yield('content')
        </section>
    </main>
</div>
</body>
</html>
