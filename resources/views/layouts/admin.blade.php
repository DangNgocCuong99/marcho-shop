<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>AdminLTE 3 | Dashboard</title>
    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <!-- Tell the browser to be responsive to screen width -->
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <!-- Custom Style -->
    {!! \Assets::renderHeader() !!}

    @yield('style')
</head>

<body class="hold-transition sidebar-mini layout-fixed">
    <div class="wrapper">

        <!-- Navbar -->
        <nav class="main-header navbar navbar-expand navbar-white navbar-light text-lg">
            <!-- Left navbar links -->
            <ul class="navbar-nav">
                <li class="nav-item">
                    <a class="nav-link" data-widget="pushmenu" href="#" role="button"><i class="fas fa-bars"></i></a>
                </li>
            </ul>

            <!-- Right navbar links -->
            <ul class="navbar-nav ml-auto">
                <li class="nav-item d-none d-sm-inline-block">
                    <a href="{{ route('home') }}" class="nav-link"><i class="fal fa-undo"></i> Trang chủ</a>
                </li>

                <li class="dropdown user user-menu">
                    <a href="#" class="nav-link dropdown-toggle" data-toggle="dropdown" aria-expanded="false">
                        <img loading="lazy" src="{{ asset(auth()->user()->avatar ? auth()->user()->avatar : 'assets/img/user2-160x160.jpg') }}" class="img-circle elevation-1 user-image" alt="User Image">
                        <span class="hidden-xs text-capitalize">{{ auth()->user()->name }}</span>
                    </a>

                    <div class="dropdown-menu dropdown-menu-right">
                        <a href="{{route('admin.profile')}}" class="dropdown-item">
                            <i class="fal fa-id-card"></i> Trang cá nhân
                        </a>
                        <div class="dropdown-divider"></div>
                        <form id="logout-form" action="{{ route('logout') }}" method="POST">
                            @csrf
                            <button type="submit" class="dropdown-item">
                                <i class="fal fa-sign-out"></i> Đăng xuất
                            </button>
                        </form>
                    </div>
                </li>
            </ul>
        </nav>
        <!-- /.navbar -->

        <!-- Main Sidebar Container -->
        <aside class="main-sidebar sidebar-dark-primary elevation-4">
            <!-- Brand Logo -->
            <a href="{{ route('admin.dashboard') }}" class="brand-link">
                <img loading="lazy" src="{{ asset('assets/img/AdminLTELogo.png') }}" alt="AdminLTE Logo" class="brand-image img-circle elevation-3" style="opacity: .8">
                <span class="brand-text font-weight-light">Admin</span>
            </a>

            <!-- Sidebar -->
            <div class="sidebar">
                <!-- Sidebar Menu -->
                <nav class="mt-2">
                    <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
                        <li class="nav-item">
                            <a href="{{ route('admin.dashboard') }}" class="nav-link {{ (request()->routeIs('admin.dashboard*')) ? 'active' : '' }}">
                                <i class="nav-icon fal fa-tachometer-alt"></i>
                                <p>
                                    Bảng điều khiển
                                </p>
                            </a>
                        </li>

                        @can('admin.category.index')
                        <li class="nav-item">
                            <a href="{{ route('admin.category.index') }}" class="nav-link {{ (request()->routeIs('admin.category.*')) ? 'active' : '' }}">
                                <i class="nav-icon fal fa-folder"></i>
                                <p>
                                    Danh mục
                                </p>
                            </a>
                        </li>
                        @endcan

                        @canany(['admin.product.index','admin.attribute.index'])
                        <li class="nav-item has-treeview {{ (request()->routeIs(['admin.product.*', 'admin.attribute.*'])) ? 'menu-open' : '' }}">
                            <a href="#" class="nav-link {{ (request()->routeIs(['admin.product.*', 'admin.attribute.*'])) ? 'active' : '' }}">
                                <i class="nav-icon fal fa-shopping-bag"></i>
                                <p>
                                    Sản phẩm
                                    <i class="fas fa-angle-left right"></i>
                                </p>
                            </a>
                            <ul class="nav nav-treeview">
                                @can('admin.product.index')
                                <li class="nav-item">
                                    <a href="{{ route('admin.product.index') }}" class="nav-link {{ (request()->routeIs('admin.product.*')) ? 'active' : '' }}">
                                        <i class="far fa-circle nav-icon"></i>
                                        <p>
                                            Danh sách sản phẩm
                                        </p>
                                    </a>
                                </li>
                                @endcan

                                @can('admin.attribute.index')
                                <li class="nav-item">
                                    <a href="{{ route('admin.attribute.index') }}" class="nav-link {{ (request()->routeIs('admin.attribute.*')) ? 'active' : '' }}">
                                        <i class="far fa-circle nav-icon"></i>
                                        <p>
                                            Danh sách thuộc tính
                                        </p>
                                    </a>
                                </li>
                                @endcan
                            </ul>
                        </li>
                        @endcanany

                        @can('admin.order.index')
                        <li class="nav-item">
                            <a href="{{ route('admin.order.index') }}" class="nav-link {{ (request()->routeIs('admin.order.*')) ? 'active' : '' }}">
                                <i class="fal fa-bags-shopping nav-icon"></i>
                                <p>
                                    Đơn hàng
                                </p>
                            </a>
                        </li>
                        @endcan

                        @can('admin.blog.index')
                        <li class="nav-item has-treeview {{ (request()->routeIs(['admin.blog.*', 'admin.comment.*'])) ? 'menu-open' : '' }}">
                            <a href="{{ route('admin.blog.index') }}" class="nav-link {{ (request()->routeIs(['admin.blog.*', 'admin.comment.*'])) ? 'active' : '' }}">
                                <i class="nav-icon fal fa-book-alt"></i>
                                <p>
                                    Bài viết
                                </p>
                            </a>
                        </li>
                        @endcan

                        @canany(['admin.user.index','admin.role.index','admin.permission.index'])
                        <li class="nav-item has-treeview {{ (request()->routeIs(['admin.user*', 'admin.role*','admin.permission*'])) ? 'menu-open' : '' }}">
                            <a href="#/" class="nav-link {{ (request()->routeIs(['admin.user*', 'admin.role*','admin.permission*'])) ? 'active' : '' }}">
                                <i class="nav-icon fal fa-user"></i>
                                <p>
                                    Người dùng
                                    <i class="right fas fa-angle-left"></i>
                                </p>
                            </a>
                            <ul class="nav nav-treeview">
                                @can('admin.user.index')
                                <li class="nav-item">
                                    <a href="{{ route('admin.user.index') }}" class="nav-link {{ (request()->routeIs('admin.user*')) ? 'active' : '' }}">
                                        <i class="far fa-circle nav-icon"></i>
                                        <p>Quản lí người dùng</p>
                                    </a>
                                </li>
                                @endcan

                                @can('admin.role.index')
                                <li class="nav-item">
                                    <a href="{{route('admin.role.index')}}" class="nav-link {{ (request()->routeIs('admin.role*')) ? 'active' : '' }}">
                                        <i class="far fa-circle nav-icon"></i>
                                        <p>Nhóm quyền</p>
                                    </a>
                                </li>
                                @endcan

                                @can('admin.permission.index')
                                <li class="nav-item">
                                    <a href="{{route('admin.permission.index')}}" class="nav-link {{ (request()->routeIs('admin.permission*')) ? 'active' : '' }}">
                                        <i class="far fa-circle nav-icon"></i>
                                        <p>Quyền</p>
                                    </a>
                                </li>
                                @endcan
                            </ul>
                        </li>
                        @endcanany

                        <li class="nav-header">CÀI ĐẶT</li>
                        @can('admin.slider.index')
                        <li class="nav-item">
                            <a href="{{ route('admin.slider.index') }}" class="nav-link {{ (request()->routeIs('admin.slider.*')) ? 'active' : '' }}">
                                <i class="nav-icon fal fa-book-alt"></i>
                                <p>
                                    Slider
                                </p>
                            </a>
                        </li>
                        @endcan
                    </ul>
                </nav>
                <!-- /.sidebar-menu -->
            </div>
            <!-- /.sidebar -->
        </aside>

        <!-- Content Wrapper. Contains page content -->
        <div class="content-wrapper">
            <div id="app">
                @yield('main')
            </div>
        </div>
        <!-- /.content-wrapper -->
        <footer class="main-footer">
            <strong>Copyright &copy; 2021 DangNgocCuong</a>.</strong>
            All rights reserved.
                   </footer>

        <!-- Control Sidebar -->
        <aside class="control-sidebar control-sidebar-dark">
            <!-- Control sidebar content goes here -->
        </aside>
        <!-- /.control-sidebar -->
    </div>
    <!-- ./wrapper -->

    <!-- Custom Script -->
    {!! \Assets::renderFooter() !!}

    @yield('script')
    <!-- Resolve conflict in jQuery UI tooltip with Bootstrap tooltip -->
    <script>
        $.widget.bridge('uibutton', $.ui.button);
    </script>

    @if(session('success'))
    <script>
        $(function() {
            Swal.fire({
                toast: true,
                position: "bottom-end",
                showConfirmButton: false,
                timer: 3000,
                icon: "success",
                title: "{{ session('success') }}",
            });
        });
    </script>
    @endif

    @if(session('error'))
    <script>
        $(function() {
            Swal.fire({
                toast: true,
                position: "bottom-end",
                showConfirmButton: false,
                timer: 3000,
                icon: "error",
                title: "{{ session('error') }}",
            });
        });
    </script>
    @endif
</body>

</html>