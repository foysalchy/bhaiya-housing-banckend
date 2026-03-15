<!doctype html>
<html lang="en">
<!--begin::Head-->

<head>
  <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
  <title>{{env('APP_NAME')}} - @yield('title')</title>
  <!--begin::Accessibility Meta Tags-->
  <meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=yes" />
  <meta name="color-scheme" content="light dark" />
  <meta name="theme-color" content="#007bff" media="(prefers-color-scheme: light)" />
  <meta name="theme-color" content="#1a1a1a" media="(prefers-color-scheme: dark)" />

  <link rel="preload" href="{{asset('/')}}backend/css/adminlte.css" as="style" />
  <!--end::Accessibility Features-->
  <!--begin::Fonts-->
  <link
    rel="stylesheet"
    href="https://cdn.jsdelivr.net/npm/@fontsource/source-sans-3@5.0.12/index.css"
    integrity="sha256-tXJfXfp6Ewt1ilPzLDtQnJV4hclT9XuaZUKyUvmyr+Q="
    crossorigin="anonymous"
    media="print"
    onload="this.media='all'" />
  <!--end::Fonts-->
  <!--begin::Third Party Plugin(OverlayScrollbars)-->
  <link
    rel="stylesheet"
    href="https://cdn.jsdelivr.net/npm/overlayscrollbars@2.11.0/styles/overlayscrollbars.min.css"
    crossorigin="anonymous" />
  <!--end::Third Party Plugin(OverlayScrollbars)-->
  <!--begin::Third Party Plugin(Bootstrap Icons)-->
  <link
    rel="stylesheet"
    href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.13.1/font/bootstrap-icons.min.css"
    crossorigin="anonymous" />
  <!--end::Third Party Plugin(Bootstrap Icons)-->
  <!--begin::Required Plugin(AdminLTE)-->
  <link rel="stylesheet" href="{{asset('/')}}backend/css/adminlte.css" />
  <!--end::Required Plugin(AdminLTE)-->
  <!-- apexcharts -->
  <link
    rel="stylesheet"
    href="https://cdn.jsdelivr.net/npm/apexcharts@3.37.1/dist/apexcharts.css"
    integrity="sha256-4MX+61mt9NVvvuPjUWdUdyfZfxSB1/Rf9WtqRHgG5S0="
    crossorigin="anonymous" />
  <!-- jsvectormap -->
  <link
    rel="stylesheet"
    href="https://cdn.jsdelivr.net/npm/jsvectormap@1.5.3/dist/css/jsvectormap.min.css"
    integrity="sha256-+uGLJmmTKOqBr+2E6KDYs/NRsHxSkONXFHUL0fy2O/4="
    crossorigin="anonymous" />
</head>
<!--end::Head-->
<!--begin::Body-->

<body class="layout-fixed sidebar-expand-lg sidebar-open bg-body-tertiary">
  <!--begin::App Wrapper-->
  <div class="app-wrapper">
    <!--begin::Header-->
    <nav class="app-header navbar navbar-expand bg-body">
      <!--begin::Container-->
      <div class="container-fluid">
        <!--begin::Start Navbar Links-->
        <ul class="navbar-nav">
          <li class="nav-item">
            <a class="nav-link" data-lte-toggle="sidebar" href="#" role="button">
              <i class="bi bi-list"></i>
            </a>
          </li>
          <li class="nav-item d-none d-md-block"><a href="/" class="nav-link">Home</a></li>
        </ul>
        <!--end::Start Navbar Links-->
        <!--begin::End Navbar Links-->

        <!--end::End Navbar Links-->
      </div>
      <!--end::Container-->
    </nav>
    <!--end::Header-->
    <style>
      .active {
        background: #484e53 !important
      }
    </style>
    <!--begin::Sidebar-->
    <aside class="app-sidebar bg-body-secondary shadow" data-bs-theme="dark">
      <!--begin::Sidebar Brand-->
      <div class="sidebar-brand">
        <!--begin::Brand Link-->
        <a href="/" class="brand-link">
          <!--begin::Brand Image-->

          <!--end::Brand Image-->
          <!--begin::Brand Text-->
          <span class="brand-text fw-light">Saltbay Admin Portal</span>
          <!--end::Brand Text-->
        </a>
        <!--end::Brand Link-->
      </div>
      <!--end::Sidebar Brand-->
      <!--begin::Sidebar Wrapper-->
      <div class="sidebar-wrapper">
        <nav class="mt-2">
          <!--begin::Sidebar Menu-->
          <ul
            class="nav sidebar-menu flex-column"
            data-lte-toggle="treeview"
            role="navigation"
            aria-label="Main navigation"
            data-accordion="false"
            id="navigation">
            <li id="search">
              <input type="text" id="menuSearch" class="form-control" placeholder="Search menu...">
            </li>

            <li class="nav-item">
              <a href="/home" class="nav-link">
                <i class="nav-icon bi bi-circle text-info"></i>
                <p>Dashboard</p>
              </a>
            </li>
            <!-- @foreach($contents  as $field => $data)

              @if($field=='about-us' || $field=='founding-member' || $field=='albums' || $field=='research' || $field=='pages')
              <li style="margin: 0;border-bottom: 1px solid var(--bs-border-color)"></li>
              @endif
              <li class="nav-item nav-items ">
                <a href="#" class="nav-link  ">
                   <i class="nav-icon bi bi-circle text-info"></i>
                  <p>
                    {{ ucwords(str_replace(['-', '_'], ' ', $field)) }}

                    <i class="nav-arrow bi bi-chevron-right"></i>
                  </p>
                </a>
                <ul class="nav nav-treeview">
                  <li class="nav-item">

                    <a href="{{route('content.create',$field)}}" class="nav-link  ">
                      <i class="nav-icon bi bi-circle"></i>
                      <p>Create</p>
                    </a>
                  </li>
                  <li class="nav-item">
                    <a href="{{route('content.index',$field)}}" class="nav-link">
                      <i class="nav-icon bi bi-circle"></i>
                      <p>List</p>
                    </a>
                  </li>
                </ul>
              </li>
              @endforeach -->
            <li style="margin: 0;border-bottom: 1px solid var(--bs-border-color)"></li>

            @foreach($contents as $field => $data)

            @php
            $isActive = request()->routeIs('content.create') && request()->route('type') == $field
            || request()->routeIs('content.index') && request()->route('type') == $field;
            @endphp

            @if(in_array($field, ['about-us','founding-member','albums','research','pages']))
            <li style="margin: 0;border-bottom: 1px solid var(--bs-border-color)"></li>
            @endif

            <li class="nav-item nav-items {{ $isActive ? 'menu-open' : '' }}">
              <a href="#" class="nav-link {{ $isActive ? 'active' : '' }}">
                <i class="nav-icon bi bi-circle text-info"></i>
                <p>
                  {{ ucwords(str_replace(['-', '_'], ' ', $field)) }}
                  <i class="nav-arrow bi bi-chevron-right"></i>
                </p>
              </a>

              <ul class="nav nav-treeview">
                <li class="nav-item">
                  <a href="{{ route('content.create', $field) }}"
                    class="nav-link {{ request()->routeIs('content.create') && request()->route('type') == $field ? 'active' : '' }}">
                    <i class="nav-icon bi bi-circle"></i>
                    <p>Create</p>
                  </a>
                </li>

                <li class="nav-item">
                  <a href="{{ route('content.index', $field) }}"
                    class="nav-link {{ request()->routeIs('content.index') && request()->route('type') == $field ? 'active' : '' }}">
                    <i class="nav-icon bi bi-circle"></i>
                    <p>List</p>
                  </a>
                </li>
              </ul>
            </li>

            @endforeach


            <li style="margin: 0;border-bottom: 1px solid var(--bs-border-color)"></li>

            <li class="nav-item">
              <a href="/contact-list" class="nav-link">
                <i class="nav-icon bi bi-circle text-info"></i>
                <p>Contact</p>
              </a>
            </li>
            

            <li class="nav-item">
              <a href="#" class="nav-link" href="{{ route('logout') }}" onclick="event.preventDefault();  document.getElementById('logout-form').submit();">

                <p>LogOut <i class="nav-arrow bi bi-box-arrow-left text-info"></i></p>
              </a>


              <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                @csrf
              </form>
            </li>
          </ul>
          <!--end::Sidebar Menu-->
        </nav>
      </div>
      <!--end::Sidebar Wrapper-->
    </aside>
    <!--end::Sidebar-->
    <!--begin::App Main-->
    <main class="app-main">
      <!--begin::App Content Header-->
      @if(session('status'))
      <div class="container mt-4">
        <div class="alert alert-success alert-dismissible fade show" role="alert">
          {{ session('status') }}
          <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
      </div>
      @endif
      @yield('content')
    </main>
    <!--end::App Main-->
    <!--begin::Footer-->
    <footer class="app-footer">

      <strong>
        Design & Developed By © <a target="_blank" href="https://bhaiya.digital">Bhaiya Digital</a>.
      </strong>
      <!--end::Copyright-->
    </footer>
    <!--end::Footer-->
  </div>
  <!--end::App Wrapper-->
  <!--begin::Script-->
  <!--begin::Third Party Plugin(OverlayScrollbars)-->
  <script
    src="https://cdn.jsdelivr.net/npm/overlayscrollbars@2.11.0/browser/overlayscrollbars.browser.es6.min.js"
    crossorigin="anonymous"></script>
  <!--end::Third Party Plugin(OverlayScrollbars)--><!--begin::Required Plugin(popperjs for Bootstrap 5)-->
  <script
    src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.8/dist/umd/popper.min.js"
    crossorigin="anonymous"></script>
  <!--end::Required Plugin(popperjs for Bootstrap 5)--><!--begin::Required Plugin(Bootstrap 5)-->
  <script
    src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.7/dist/js/bootstrap.min.js"
    crossorigin="anonymous"></script>
  <!--end::Required Plugin(Bootstrap 5)--><!--begin::Required Plugin(AdminLTE)-->
  <script src="{{asset('/')}}backend/js/adminlte.js"></script>
  <!--end::Required Plugin(AdminLTE)--><!--begin::OverlayScrollbars Configure-->
  <script>
    const SELECTOR_SIDEBAR_WRAPPER = '.sidebar-wrapper';
    const Default = {
      scrollbarTheme: 'os-theme-light',
      scrollbarAutoHide: 'leave',
      scrollbarClickScroll: true,
    };
    document.addEventListener('DOMContentLoaded', function() {
      const sidebarWrapper = document.querySelector(SELECTOR_SIDEBAR_WRAPPER);
      if (sidebarWrapper && OverlayScrollbarsGlobal?.OverlayScrollbars !== undefined) {
        OverlayScrollbarsGlobal.OverlayScrollbars(sidebarWrapper, {
          scrollbars: {
            theme: Default.scrollbarTheme,
            autoHide: Default.scrollbarAutoHide,
            clickScroll: Default.scrollbarClickScroll,
          },
        });
      }
    });
  </script>
  <!--end::OverlayScrollbars Configure-->
  <!-- OPTIONAL SCRIPTS -->
  <!-- sortablejs -->
  <script>
    document.addEventListener('DOMContentLoaded', function() {
      const input = document.getElementById('menuSearch');
      const menuItems = document.querySelectorAll('.nav-items');

      input.addEventListener('keyup', function() {
        const filter = input.value.toLowerCase();

        menuItems.forEach(item => {
          const text = item.innerText.toLowerCase();
          if (text.includes(filter)) {
            item.style.display = '';
          } else {
            item.style.display = 'none';
          }
        });
      });
    });
  </script>

  @stack('scripts')
</body>
<!--end::Body-->

</html>
