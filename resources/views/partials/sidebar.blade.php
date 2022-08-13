<aside class="main-sidebar sidebar-dark-primary elevation-4">
    <!-- Brand Logo -->
    <a href="index3.html" class="brand-link">
      <img src="/dist/img/AdminLTELogo.png" alt="AdminLTE Logo" class="brand-image img-circle elevation-3"
           style="opacity: .8">
      <span class="brand-text font-weight-light">AdminLTE 3</span>
    </a>

    <!-- Sidebar -->
    <div class="sidebar">
      <!-- Sidebar user panel (optional) -->
      <div class="user-panel mt-3 pb-3 mb-3 d-flex">
        <div class="image">
          <img src="/dist/img/user2-160x160.jpg" class="img-circle elevation-2" alt="User Image">
        </div>
        <div class="info">
          <a href="#" class="d-block">{{auth()->user()->name}}</a>
        </div>
      </div>

      <!-- Sidebar Menu -->

        <nav class="mt-2" id="sidebar-menu">
            <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
                <li class="nav-item">
                    <a href="javascript:void(0)"  class="nav-link">
                        <p>Quản lý hệ thống</p>
                    </a>
                    <ul class="nav nav-treeview">
                        <li class="nav-item">
                            <a href="{{route('admin.product.index')}}" class="nav-link">
                                <p>Sản phẩm</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="{{route('admin.category.index')}}" class="nav-link">
                                <p>Danh mục sản phẩm</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="{{route('admin.user.index')}}" class="nav-link">
                                <p>Nhân viên</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="{{route('admin.accounting_entry.index')}}" class="nav-link">
                                <p>Bút toán thu chi</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="{{route('admin.customer.index')}}" class="nav-link">
                                <p>Khách hàng</p>
                            </a>
                        </li>
                    </ul>
                </li>
            </ul>
            <ul class="nav nav-business nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
                <li class="nav-item">
                    <a href="javascript:void(0)" class="nav-link">
                        <p>Nghiệp vụ</p>
                    </a>
                    <ul class="nav nav-treeview">
                        <li class="nav-item">
                            <a href="{{route('admin.formexport.index')}}" class="nav-link">
                                <p>Xuất hàng</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="{{route('admin.payment.index')}}" class="nav-link">
                                <p>Phiếu chi</p>
                            </a>
                        </li>
                    </ul>
                </li>
            </ul>
            <ul class="nav nav-report nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
                <li class="nav-item">
                    <a href="javascript:void(0)" class="nav-link">
                        <p>Báo cáo thống kê</p>
                    </a>
                    <ul class="nav nav-treeview">
                        <li class="nav-item">
                            <a class="nav-link" href="{{route('admin.fundbook.index')}}">
                                <p>Sổ quỹ</p>
                            </a>
                        </li>
                    </ul>
                </li>
            </ul>
        </nav>


    </div>
    <!-- /.sidebar -->
  </aside>
