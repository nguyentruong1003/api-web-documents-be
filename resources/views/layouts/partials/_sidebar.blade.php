<!-- Main Sidebar Container -->
  <aside class="main-sidebar sidebar-dark-primary elevation-4">
    <!-- Brand Logo -->
    <a href="{{ route('home') }}" class="brand-link">
      <img src="/dist/img/AdminLTELogo.png" alt="AdminLTE Logo" class="brand-image img-circle elevation-3" style="opacity: .8">
      <span class="brand-text font-weight-light">Admin Dashboard</span>
    </a>

    <!-- Sidebar -->
    <div class="sidebar">
      <!-- Sidebar user panel (optional) -->
      <div class="user-panel mt-3 pb-3 mb-3 d-flex">
        <div class="image">
          <img src="/dist/img/user2-160x160.jpg" class="img-circle elevation-2" alt="User Image">
        </div>
        <div class="info">
          <a href="{{ route('home') }}" class="d-block">Admin</a>
        </div>
      </div>

      <!-- SidebarSearch Form -->

      <!-- Sidebar Menu -->
      <nav class="mt-2">
        <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
          <!-- Add icons to the links using the .nav-icon class
               with font-awesome or any other icon font library -->
          @if (checkPermission('user.index') || checkPermission('role.index'))
          <li class="nav-item {{ setOpen('users') }} {{ setOpen('roles') }}">
            <a href="#" class="nav-link">
              <i class="nav-icon far fa-user"></i>
              <p>
                Quản trị hệ thống
                <i class="fas fa-angle-left right"></i>
              </p>
            </a>
            <ul class="nav nav-treeview">
              @if (checkPermission('user.index'))
              <li class="nav-item">
                <a href="{{ route('admin.user.index') }}" class="nav-link {{ setActive('users') }}">
                  <i class="far fa-circle nav-icon"></i>
                  <p>Danh sách người dùng</p>
                </a>
              </li>
              @endif
              @if (checkPermission('role.index'))
              <li class="nav-item">
                <a href="{{ route('admin.role.index') }}" class="nav-link {{ setActive('roles') }}">
                  <i class="far fa-circle nav-icon"></i>
                  <p>Danh sách vai trò</p>
                </a>
              </li>
              @endif
            </ul>
          </li>
          @endif
          {{-- @if (checkPermission('master-data.index') || checkPermission('audit.index'))
          <li class="nav-item {{ setOpen('master-data') }} {{ setOpen('audits') }}">
            <a href="#" class="nav-link">
              <i class="nav-icon far fa-file"></i>
              <p>
                Quản lý cấu hình
                <i class="fas fa-angle-left right"></i>
              </p>
            </a>
            <ul class="nav nav-treeview">
              @if (checkPermission('master-data.index'))
              <li class="nav-item">
                <a href="{{ route('admin.master-data.index') }}" class="nav-link {{ setActive('master-data') }}">
                  <i class="far fa-circle nav-icon"></i>
                  <p>Master Data</p>
                </a>
              </li>
              @endif
              @if (checkPermission('audit.index'))
              <li class="nav-item">
                <a href="{{ route('admin.audit.index') }}" class="nav-link {{ setActive('audits') }}">
                  <i class="far fa-circle nav-icon"></i>
                  <p>Audit Log</p>
                </a>
              </li>
              @endif
            </ul>
          </li>
          @endif --}}

          {{-- @if (checkPermission('master-data.index') || checkPermission('audit.index')) --}}
          <li class="nav-item {{ setOpen('posts') }} {{ setOpen('post-types') }} {{ setOpen('post-reports') }} {{ setOpen('pending') }}">
            <a href="#" class="nav-link">
              <i class="nav-icon far fa-file"></i>
              <p>
                Quản lý bài viết
                <i class="fas fa-angle-left right"></i>
              </p>
            </a>
            <ul class="nav nav-treeview">
              {{-- @if (checkPermission('master-data.index')) --}}
              <li class="nav-item">
                <a href="{{ route('admin.post.index') }}" class="nav-link {{ setActive('posts') }}">
                  <i class="far fa-circle nav-icon"></i>
                  <p>Danh sách bài viết</p>
                </a>
              </li>
              {{-- @endif --}}
              {{-- @if (checkPermission('master-data.index')) --}}
              <li class="nav-item">
                <a href="{{ route('admin.post-type.index') }}" class="nav-link {{ setActive('post-types') }}">
                  <i class="far fa-circle nav-icon"></i>
                  <p>Danh sách loại bài viết</p>
                </a>
              </li>
              {{-- @endif --}}
              @if (checkPermission('report.index'))
              <li class="nav-item">
                <a href="{{ route('admin.post-report.index') }}" class="nav-link {{ setActive('post-reports') }}">
                  <i class="far fa-circle nav-icon"></i>
                  <p>Danh sách phản hồi</p>
                </a>
              </li>
              @endif
              {{-- @if (checkPermission('master-data.index')) --}}
              <li class="nav-item">
                <a href="{{ route('admin.post.pending') }}" class="nav-link {{ setActive('pending') }}">
                  <i class="far fa-circle nav-icon"></i>
                  <p>Danh sách bài viết đang chờ phê duyệt</p>
                </a>
              </li>
              {{-- @endif --}}
            </ul>
          </li>
          {{-- @endif --}}
          
          
        </ul>
      </nav>
      <!-- /.sidebar-menu -->
    </div>
    <!-- /.sidebar -->
  </aside>
