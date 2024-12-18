<aside class="main-sidebar">
    <!-- sidebar: style can be found in sidebar.less -->
    <section class="sidebar">
      <!-- Sidebar user panel -->
      <div class="user-panel">
        <div class="pull-left image">
          <img src="{{asset('AdminLTE-2/dist/img/avatar.png')}}" class="img-circle" alt="User Image">
        </div>
        <div class="pull-left info">
          <p>Zulfikar</p>
          <a href="#"><i class="fa fa-circle text-success"></i> Online</a>
        </div>
      </div>
      <!-- search form -->
      <form action="#" method="get" class="sidebar-form">
        <div class="input-group">
          <input type="text" name="q" class="form-control" placeholder="Search...">
          <span class="input-group-btn">
                <button type="submit" name="search" id="search-btn" class="btn btn-flat"><i class="fa fa-search"></i>
                </button>
              </span>
        </div>
      </form>
      <!-- /.search form -->
      <!-- sidebar menu: : style can be found in sidebar.less -->
      <ul class="sidebar-menu" data-widget="tree">
      <li>
        <li>
          <a href="{{route('dashboard.index')}}">
            <i class="fa fa-dashboard"></i> <span>Dashboard</span>
            </span>
          </a>
        </li>
        <li class="header">CAFE</li>
        <li>
          <a href="{{route('menu.index')}}">
            <i class="fa fa-cutlery"></i> <span>Menu</span>
            </span>
          </a>
        </li>
        <li>
          <a href="{{route('meja.index')}}">
            <i class="fa fa-th"></i> <span>Meja</span>
            </span>
          </a>
        </li>
        <li>
          <a href="{{route('pesanan.index')}}">
            <i class="fa fa-sticky-note"></i> <span>Pesanan</span>
            </span>
          </a>
        </li>
        <li class="header">BILIARD</li>
        <li>
          <a href="{{route('paketbiliard.index')}}">
            <i class="fa fa-list-ol"></i> <span>Paket Biliard</span>
            </span>
          </a>
        </li>
        <li>
        <li>
          <a href="{{route('mejabiliard.index')}}" >
            <i class="fa fa-futbol-o"></i> <span>Meja Biliard</span>
            </span>
          </a>
        </li>
        <li>
          <a href="{{route('orderbiliard.index')}}">
            <i class="fa fa-sticky-note-o"></i> <span>Order Biliard</span>
            </span>
          </a>
        </li>
        <li class="header">REPORT</li>
        <li>
          <a href="{{route('laporan.index')}}">
            <i class="fa fa-file-pdf-o"></i> <span>Report Singkat</span>
            </span>
          </a>
        </li>
        <li>
          <a href="{{route('laporan.indexcafe')}}">
            <i class="fa fa-file-text-o"></i> <span>Report Cafe</span>
            </span>
          </a>
        </li>
        <li>
          <a href="{{route('laporan.indexbiliard')}}">
            <i class="fa fa-file-text-o"></i> <span>Report Biliard</span>
            </span>
          </a>
        </li>  
        <li class="header">USER</li>
        <li>
          <a href="pages/widgets.html">
            <i class="fa fa-user"></i> <span>User</span>
            </span>
          </a>
        </li>  
      </ul>
    </section>
    <!-- /.sidebar -->
  </aside>