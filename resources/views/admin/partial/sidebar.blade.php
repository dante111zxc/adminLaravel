<aside class="main-sidebar">
    <!-- sidebar: style can be found in sidebar.less -->
    <section class="sidebar">

        <div class="user-panel">
            <div class="pull-left image">
                <img src="{{ asset('adminLTE/dist/img/user2-160x160.jpg') }}" class="img-circle" alt="User Image">
            </div>
            <div class="pull-left info">
                <p>{{ Auth::user()->name }}</p>
                <a href="#"><i class="fa fa-circle text-success"></i> Online</a>
            </div>
        </div>

        <!-- sidebar menu: : style can be found in sidebar.less -->
        <ul class="sidebar-menu" data-widget="tree">
            <li class="header">MAIN NAVIGATION</li>
            <li>
                <a href="{{ route('admin.dashboard') }}">
                    <i class="fa fa-dashboard"></i> <span>Dashboard</span>
                </a>
            </li>

            <li class="treeview">
                <a href="javascript:void (0)">
                    <i class="fa fa-user"></i> <span>Quản trị viên</span>
                    <span class="pull-right-container">
                        <i class="fa fa-angle-left pull-right"></i>
                    </span>
                </a>
                <ul class="treeview-menu">
                    @can('admin.view')
                    <li>
                        <a href="{{ route('admin.index') }}"><i class="fa fa-circle-o"></i> Danh sách</a>
                    </li>
                    @endcan

                    @can('role.view')
                    <li>
                        <a href="{{ route('role.index') }}"><i class="fa fa-circle-o"></i> Nhóm quyền</a>
                    </li>
                    @endcan
                </ul>
            </li>
            <li class="treeview">
                <a href="javascript:void (0)">
                    <i class="fa fa-edit"></i> <span>Bài viết</span>
                    <span class="pull-right-container">
                        <i class="fa fa-angle-left pull-right"></i>
                    </span>
                </a>
                <ul class="treeview-menu">
                    @can('category.view')
                    <li>
                        <a href="{{ route('category.index') }}"><i class="fa fa-circle-o"></i> Danh mục</a>
                    </li>
                    @endcan

                    @can('tag.view')
                    <li>
                        <a href="{{ route('tag.index') }}"><i class="fa fa-circle-o"></i> Thẻ tag</a>
                    </li>
                    @endcan

                    @can('post.view')
                    <li>
                        <a href="{{ route('post.index') }}"><i class="fa fa-circle-o"></i> Bài viết</a>
                    </li>
                    @endcan
                </ul>
            </li>

            <li class="treeview">
                <a href="javascript:void (0)">
                    <i class="fa fa-archive"></i> <span>Sản phẩm</span>
                    <span class="pull-right-container">
                        <i class="fa fa-angle-left pull-right"></i>
                    </span>
                </a>
                <ul class="treeview-menu">

                    @can('product.view')
                        <li>
                            <a href="{{ route('product.index') }}"><i class="fa fa-circle-o"></i> Sản phẩm</a>
                        </li>
                    @endcan

                    @can('product-category.view')
                    <li>
                        <a href="{{ route('product-category.index') }}"><i class="fa fa-circle-o"></i> Danh mục sản phẩm</a>
                    </li>
                    @endcan



                    @can('product-tag.view')
                        <li>
                            <a href="{{ route('product-tag.index') }}"><i class="fa fa-circle-o"></i> Thẻ tag sản phẩm</a>
                        </li>
                    @endcan

                    @can('product-attributes.view')
                        <li>
                            <a href="{{ route('product-attributes.index') }}"><i class="fa fa-circle-o"></i> Thuộc tính sản phẩm</a>
                        </li>
                    @endcan


                    @can('order.view')
                        <li>
                            <a href="{{ route('order.index') }}"><i class="fa fa-circle-o"></i> Đơn hàng</a>
                        </li>
                    @endcan


                </ul>
            </li>

            @can('page.view')
            <li>
                <a href="{{ route('page.index') }}"><i class="fa fa-newspaper-o"></i> Trang</a>
            </li>
            @endcan

            @can('reviews.view')
                <li>
                    <a href="{{ route('reviews.index') }}"><i class="fa fa-commenting-o"></i> Bình luận</a>
                </li>
            @endcan

            @can('methodpayments.view')
            <li>
                <a href="{{ route('methodpayments.index') }}">
                    <i class="fa fa-money"></i> <span> Thanh toán</span>
                </a>
            </li>
            @endcan

            @can('user.view')
                <li>
                    <a href="{{ route('user.index') }}">
                        <i class="fa fa-users"></i> <span> Thành viên</span>
                    </a>
                </li>
            @endcan


            <li class="treeview">
                <a href="javascript:void (0)">
                    <i class="fa fa-credit-card"></i> <span> Lịch sử giao dịch</span>
                    <span class="pull-right-container">
                        <i class="fa fa-angle-left pull-right"></i>
                    </span>
                </a>
                <ul class="treeview-menu">
                    @can('transactionpcoin.view')
                        <li>
                            <a href="{{ route('transaction-pcoin.index') }}"><i class="fa fa-circle-o"></i> Lịch sử nạp Pcoin</a>
                        </li>
                    @endcan

                </ul>

            </li>



            <li class="treeview">
                <a href="javascript:void (0)">
                    <i class="fa fa-gear"></i> <span> Cài đặt</span>
                    <span class="pull-right-container">
                        <i class="fa fa-angle-left pull-right"></i>
                    </span>
                </a>
                <ul class="treeview-menu">
                    @can('setting.view')
                    <li>
                        <a href="{{ route('setting.index') }}"><i class="fa fa-circle-o"></i> Cấu hình chung</a>
                    </li>
                    @endcan

                    @can('menuposition.view')
                        <li>
                            <a href="{{ route('menuposition.index') }}"><i class="fa fa-circle-o"></i> Menu</a>
                        </li>
                    @endcan


                    @can('slides.view')
                        <li>
                            <a href="{{ route('slides.index') }}"><i class="fa fa-circle-o"></i> Slide trang chủ</a>
                        </li>
                    @endcan

                </ul>

            </li>





        </ul>
    </section>
    <!-- /.sidebar -->
</aside>
