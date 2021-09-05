<!-- Main Sidebar Container -->
  <aside class="main-sidebar sidebar-dark-primary elevation-4">
    <!-- Brand Logo -->
    <a href="#" class="brand-link">
      <img src="{{ asset('template/dist/img/download.png') }}" alt="" class="brand-image img-circle elevation-3" style="opacity: .8">
      <span class="brand-text font-weight-light">CV . Agus Wahyu </span>
    </a> 

    <!-- Sidebar -->
    <div class="sidebar">
      <!-- Sidebar user panel (optional) -->
      <!-- <div class="user-panel mt-3 pb-3 mb-3 d-flex">
        <div class="image">
		  <img src="{{ asset('template/dist/img/download.png') }}" class="img-circle elevation-2" alt="User Image">
        </div>
        <div class="info">
          <a href="#" class="d-block"></a>
        </div>
      </div> -->

      <!-- SidebarSearch Form -->
      <div class="form-inline">
        <div class="input-group" data-widget="sidebar-search">
          <input class="form-control form-control-sidebar" type="search" placeholder="Search" aria-label="Search">
          <div class="input-group-append">
            <button class="btn btn-sidebar">
              <i class="fas fa-search fa-fw"></i>
            </button>
          </div>
        </div>
      </div>

      <!-- Sidebar Menu -->
      <nav class="mt-2">
        <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
          <!-- Add icons to the links using the .nav-icon class
               with font-awesome or any other icon font library -->
          <li class="nav-item">
            <a href="#" class="nav-link">
              <i class="nav-icon fas fa-chart-pie"></i>
              <p>
                Umum
                <i class="right fas fa-angle-left"></i>
              </p>
            </a>
            <ul class="nav nav-treeview">
              <li class="nav-item">
                <a href="/tunjangan" class="nav-link">
                  <i class="far fa-circle nav-icon"></i>
                  <p>Tunjangan</p>
                </a>
              </li>
              <li class="nav-item">
                <a href="/jabatan"  class="nav-link">
                  <i class="far fa-circle nav-icon"></i>
                  <p>Jabatan</p>
                </a>
              </li>
              <li class="nav-item">
                <a href="/potongan" class="nav-link">
                  <i class="far fa-circle nav-icon"></i>
                  <p>Potongan</p>
                </a>
              </li>
            </ul>
          </li>
		  <li class="nav-item">
            <a  class="nav-link">
              <i class="nav-icon fas fa-chart-pie"></i>
              <p>
                Pegawai
                <i class="right fas fa-angle-left"></i>
              </p>
            </a>
            <ul class="nav nav-treeview">
              <li class="nav-item">
                <a href="/daftar"  class="nav-link">
                  <i class="far fa-circle nav-icon"></i>
                  <p>Daftar</p>
                </a>
              </li>
			  <li class="nav-item">
                <a  href="/absensi"   class="nav-link">
                  <i class="far fa-circle nav-icon"></i>
                  <p>Absensi</p>
                </a>
              </li>
              <li class="nav-item">
                <a href="/pengajian" class="nav-link">
                  <i class="far fa-circle nav-icon"></i>
                  <p>Penggajian</p>
                </a>
              </li>
            </ul>
          </li>
          <li class="nav-item">
          <a class="dropdown-item text-danger" href="{{ route('logout') }}"
                        onclick="event.preventDefault();
                                      document.getElementById('logout-form').submit();">
                         <i class="bx bx-power-off font-size-16 align-middle mr-1 text-danger"> {{ __('Logout') }}</i>
                        </a>

                        <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                            @csrf
                        </form>
              </li>
        </ul>
        
      </nav>
      <!-- /.sidebar-menu -->
    </div>
    <!-- /.sidebar -->
  </aside>