      @php
        $route = Route::currentRouteName();
      @endphp
      <!-- Sidebar Menu -->
      <nav class="mt-2">
        <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
          <!-- Add icons to the links using the .nav-icon class
               with font-awesome or any other icon font library -->
          @if(Auth::user()->role == 'Admin')
          <li @if($route == 'home') class="active" @else @endif>
            <a href="{{route('home')}}" @if($route == 'home') class="nav-link active" @else class="nav-link" @endif>
              <i class="nav-icon fas fa-tachometer-alt"></i>
              <p>
                Dashboard
              </p>
            </a>
          </li>
          @else
          @endif

          <!-- Sales Start -->
          <li @if($route == 'sales.index' || $route == 'sales.create' || $route == 'sales.search' || $route == 'sales.getsearch') class="nav-item has-treeview menu-open" @else class="nav-item has-treeview" @endif>
            <a href="#" @if($route == 'sales.index' || $route == 'sales.create' || $route == 'sales.search' || $route == 'sales.getsearch') class="nav-link active" @else class="nav-link" @endif>
              <i class="nav-icon fas fa-copy"></i>
              <p>
                Sales
                <i class="fas fa-angle-left right"></i>
              </p>
            </a>
            <ul class="nav nav-treeview">
              <li class="nav-item">
                <a href="{{route('sales.index')}}" @if($route == 'sales.index' || $route == 'sales.search' || $route == 'sales.getsearch') class="nav-link active" @else class="nav-link" @endif>
                  <i class="far fa-circle nav-icon"></i>
                  <p>List Sales</p>
                </a>
              </li>
              <li class="nav-item">
                <a href="{{route('sales.create')}}" @if($route == 'sales.create') class="nav-link active" @else class="nav-link" @endif>
                  <i class="far fa-circle nav-icon"></i>
                  <p>New Sales</p>
                </a>
              </li>
            </ul>
          </li>
          <!-- Sales End -->

          @if(Auth::user()->role == 'Admin')
          <!-- Products Start -->
          <li @if($route == 'products.index' || $route == 'products.import') class="nav-item has-treeview menu-open" @else class="nav-item has-treeview" @endif>
            <a href="{{route('products.index')}}" @if($route == 'products.index' || $route == 'products.import') class="nav-link active" @else class="nav-link" @endif>
              <i class="nav-icon fas fa-cube"></i>
              <p>
                Product Management
              </p>
            </a>
          </li>
          <!-- Products End -->
          @else
          @endif

          @if(Auth::user()->role == 'Admin')
          <!-- Location Start -->
          <li @if($route == 'districts.index' || $route == 'towns.index' || $route == 'districts.import') class="nav-item has-treeview menu-open" @else class="nav-item has-treeview" @endif>
            <a href="#" @if($route == 'districts.index' || $route == 'towns.index' || $route == 'districts.import') class="nav-link active" @else class="nav-link" @endif>
              <i class="nav-icon fas fa-map-marker-alt"></i>
              <p>
                Location Management
                <i class="fas fa-angle-left right"></i>
              </p>
            </a>
            <ul class="nav nav-treeview">
              <li class="nav-item">
                <a href="{{route('districts.index')}}" @if($route == 'districts.index') class="nav-link active" @else class="nav-link" @endif>
                  <i class="far fa-circle nav-icon"></i>
                  <p>Districts</p>
                </a>
              </li>
              <li class="nav-item">
                <a href="{{route('towns.index')}}" @if($route == 'towns.index') class="nav-link active" @else class="nav-link" @endif>
                  <i class="far fa-circle nav-icon"></i>
                  <p>Towns</p>
                </a>
              </li>
            </ul>
          </li>
          <!-- Location End -->
          @else
          @endif

          @if(Auth::user()->role == 'Admin')
          <!-- Retailer Start-->
          <li class="nav-item has-treeview">
            <a href="{{route('distributors.index')}}" @if($route == 'distributors.index') class="nav-link active" @else class="nav-link" @endif>
              <i class="nav-icon fas fa-user-friends"></i>
              <p>
                Distributors
              </p>
            </a>
          </li>
          <!-- Retailer End-->
          @else
          @endif

          @if(Auth::user()->role == 'Admin')
          <!-- Retailer Start-->
          <li class="nav-item has-treeview">
            <a href="{{route('retailers.index')}}" @if($route == 'retailers.index') class="nav-link active" @else class="nav-link" @endif>
              <i class="nav-icon fas fa-people-carry"></i>
              <p>
                Retailers
              </p>
            </a>
          </li>
          <!-- Retailer End-->
          @else
          @endif
         
         @if(Auth::user()->role == 'Admin')
         <!-- Communications Start -->
          <li @if($route == 'email.create' || $route == 'email.edit' || $route == 'ftp.create' || $route == 'ftp.edit' || $route == 'recepients.index') class="nav-item has-treeview menu-open" @else class="nav-item has-treeview" @endif>
            <a href="#" @if($route == 'email.create' || $route == 'email.edit' | $route == 'ftp.create' || $route == 'ftp.edit' || $route == 'recepients.index') class="nav-link active" @else class="nav-link" @endif>
              <i class="nav-icon fas fa-envelope-square"></i>
              <p>
                Communications
                <i class="fas fa-angle-left right"></i>
              </p>
            </a>
            <ul class="nav nav-treeview">
              <li class="nav-item">
                <a href="{{route('email.create')}}" @if($route == 'email.create' || $route == 'email.edit') class="nav-link active" @else class="nav-link" @endif>
                  <i class="far fa-circle nav-icon"></i>
                  <p>System Email Setting</p>
                </a>
              </li>
              <li class="nav-item">
                <a href="{{route('ftp.create')}}" @if($route == 'ftp.create' || $route == 'ftp.edit') class="nav-link active" @else class="nav-link" @endif>
                  <i class="far fa-circle nav-icon"></i>
                  <p>FTP Settings</p>
                </a>
              </li>
              <li class="nav-item">
                <a href="{{route('recepients.index')}}" @if($route == 'recepients.index') class="nav-link active" @else class="nav-link" @endif>
                  <i class="far fa-circle nav-icon"></i>
                  <p>Email Recipients</p>
                </a>
              </li>
            </ul>
          </li>
          <!-- Communications End -->
          @else
          @endif

          @if(Auth::user()->role == 'Admin')
          <!-- Users Start-->
          <li class="nav-item has-treeview">
            <a href="{{route('users.index')}}" @if($route == 'users.index') class="nav-link active" @else class="nav-link" @endif>
              <i class="nav-icon fas fa-users"></i>
              <p>
                Users
              </p>
            </a>
          </li>
          <!-- Users End-->
          @else
          @endif

        </ul>
      </nav>
      <!-- /.sidebar-menu -->
    </div>
    <!-- /.sidebar -->
  </aside>