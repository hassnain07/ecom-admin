<aside id="layout-menu" class="layout-menu menu-vertical menu bg-menu-theme">
  <div class="app-brand demo">
    <a href="index.html" class="app-brand-link">
      <span class="app-brand-logo demo">
        <img src="" alt="">
      </span>
      <span class="app-brand-text demo menu-text ms-2">
          @if(Auth::user()->store)
              {{ Auth::user()->store->name }}
          @endif
      </span>
    </a>

    <a href="javascript:void(0);" class="layout-menu-toggle menu-link text-large ms-auto d-block d-xl-none">
      <i class="bx bx-chevron-left bx-sm d-flex align-items-center justify-content-center"></i>
    </a>
  </div>

  <div class="menu-inner-shadow"></div>

  <ul class="menu-inner py-1">
    <!-- Dashboard -->
    <li class="menu-item {{ Route::is('dashboard') ? 'active' : '' }}">
      <a href="{{ route('dashboard') }}" class="menu-link">
        <i class="menu-icon tf-icons bx bx-tachometer"></i>
        <div class="text-truncate" data-i18n="Dashboards">Dashboard</div>
      </a>
    </li> 

    <!-- Categories -->
     @can('View Categories')
    <li class="menu-item {{Route::is('categories.*') ? 'active' : '' }}">
      <a href="{{ route('categories.index') }}" class="menu-link">
        <i class="menu-icon tf-icons bx bx-category"></i>
        <div class="text-truncate" data-i18n="Categories">Categories</div>
      </a>
    </li> 
    @endcan

    <!-- Stores -->
     @can('View Store')
    <li class="menu-item {{ Route::is('stores.*') ? 'active' : '' }}">
      <a href="{{ route('stores.index') }}" class="menu-link">
        <i class="menu-icon tf-icons bx bx-store"></i>
        <div class="text-truncate" data-i18n="Stores">Stores</div>
      </a>
    </li> 
    @endcan

    <!-- Products -->
     @can('View Products')
    <li class="menu-item {{ Route::is('products.*') ? 'active' : '' }}">
      <a href="{{ route('products.index') }}" class="menu-link">
        <i class="menu-icon tf-icons bx bx-package"></i>
        <div class="text-truncate" data-i18n="Products">Products</div>
      </a>
    </li> 
    @endcan
    
    <!-- Status -->
     @can('View Status')
    <li class="menu-item {{ Route::is('status.*') ? 'active' : '' }}">
      <a href="{{ route('status.index') }}" class="menu-link">
        <i class="menu-icon tf-icons bx bx-package"></i>
        <div class="text-truncate" data-i18n="Products">Status</div>
      </a>
    </li> 
    @endcan

     @can('View ProductStatus')
    <li class="menu-item {{ Route::is('product-status.*') ? 'active' : '' }}">
      <a href="{{ route('product-status.index') }}" class="menu-link">
        <i class="menu-icon tf-icons bx bx-package"></i>
        <div class="text-truncate" data-i18n="Products">Product Status</div>
      </a>
    </li> 
    @endcan

     @can('View Reviews')
    <li class="menu-item {{ Route::is('reviews.*') ? 'active' : '' }}">
      <a href="{{ route('reviews.index') }}" class="menu-link">
        <i class="menu-icon tf-icons bx bx-package"></i>
        <div class="text-truncate" data-i18n="Products">Reviews</div>
      </a>
    </li> 
    @endcan

     @can('Manage Orders')
    <li class="menu-item {{ Route::is('orders.*') ? 'active' : '' }}">
      <a href="{{ route('orders.index') }}" class="menu-link">
        <i class="menu-icon tf-icons bx bx-package"></i>
        <div class="text-truncate" data-i18n="Products">Orders</div>
      </a>
    </li> 
    @endcan
    <!-- User Management -->
    @can("View Users")
      <li class="menu-item {{ Route::is('users.*')  || Route::is('roles.*') || Route::is('permissions.*') ? 'open' : '' }}">
      <a href="javascript:void(0);" class="menu-link menu-toggle">
        <i class="menu-icon tf-icons bx bx-user-circle"></i>
        <div class="text-truncate" data-i18n="User Management">User Management</div>
      </a>
      <ul class="menu-sub">
        @can('View Users')
        <li class="menu-item {{ Route::is('users.*') ? 'active' : '' }}">
          <a href="{{ route('users.index') }}" class="menu-link">
            <i class="bx bx-user"></i>
            <div class="text-truncate" data-i18n="Users">Users</div>
          </a>
        </li>
        @endcan

        @can('View Roles')
        <li class="menu-item {{ Route::is('roles.*') ? 'active' : '' }}">
          <a href="{{ route('roles.index') }}" class="menu-link">
            <i class="bx bx-shield"></i>
            <div class="text-truncate" data-i18n="Roles">Roles</div>
          </a>
        </li>
        @endcan

        <li class="menu-item {{ Route::is('permissions.*') ? 'active' : '' }}">
          <a href="{{ route('permissions.index') }}" class="menu-link">
            <i class="bx bx-lock-alt"></i>
            <div class="text-truncate" data-i18n="Permissions">Permissions</div>
          </a>
        </li>
      </ul>
    </li> 
    @endcan
      
  </ul>
</aside>
