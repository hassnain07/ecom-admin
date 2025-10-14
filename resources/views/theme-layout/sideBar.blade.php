<aside id="layout-menu" class="layout-menu menu-vertical menu bg-menu-theme">
  <div class="app-brand demo">
    <a href="{{ route('dashboard') }}" class="app-brand-link">
     
      <span class="app-brand-text demo menu-text ms-2">
          @if(Auth::user()->hasRole('Vendor'))
              {{ Auth::user()->store->name }}
          @elseif (Auth::user()->hasRole('admin'))
              {{ Auth::user()->name }}
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
        <i class="menu-icon tf-icons bx bx-home-alt"></i>
        <div class="text-truncate">Dashboard</div>
      </a>
    </li> 

    <!-- Parent Categories -->
    @can('View Parent Category')
      <li class="menu-item {{ Route::is('parentCategories.*') ? 'active' : '' }}">
        <a href="{{ route('parentCategories.index') }}" class="menu-link">
          <i class="menu-icon tf-icons bx bx-layer"></i>
          <div class="text-truncate">Parent Categories</div>
        </a>
      </li> 
    @endcan

    <!-- Categories -->
    @can('View Categories')
      <li class="menu-item {{ Route::is('categories.*') ? 'active' : '' }}">
        <a href="{{ route('categories.index') }}" class="menu-link">
          <i class="menu-icon tf-icons bx bx-category-alt"></i>
          <div class="text-truncate">Categories</div>
        </a>
      </li> 
    @endcan

    <!-- Stores -->
    @can('View Store')
      <li class="menu-item {{ Route::is('stores.*') ? 'active' : '' }}">
        <a href="{{ route('stores.index') }}" class="menu-link">
          <i class="menu-icon tf-icons bx bx-store-alt"></i>
          <div class="text-truncate">Stores</div>
        </a>
      </li> 
    @endcan

    <!-- Products -->
    @can('View Products')
      <li class="menu-item {{ Route::is('products.*') ? 'active' : '' }}">
        <a href="{{ route('products.index') }}" class="menu-link">
          <i class="menu-icon tf-icons bx bx-package"></i>
          <div class="text-truncate">Products</div>
        </a>
      </li> 
    @endcan

    <!-- Status -->
    @can('View Status')
      <li class="menu-item {{ Route::is('status.*') ? 'active' : '' }}">
        <a href="{{ route('status.index') }}" class="menu-link">
          <i class="menu-icon tf-icons bx bx-check-shield"></i>
          <div class="text-truncate">Status</div>
        </a>
      </li> 
    @endcan

    <!-- Product Status -->
    @can('View ProductStatus')
      <li class="menu-item {{ Route::is('product-status.*') ? 'active' : '' }}">
        <a href="{{ route('product-status.index') }}" class="menu-link">
          <i class="menu-icon tf-icons bx bx-slider"></i>
          <div class="text-truncate">Product Status</div>
        </a>
      </li> 
    @endcan

    <!-- Reviews -->
    @can('View Reviews')
      <li class="menu-item {{ Route::is('reviews.*') ? 'active' : '' }}">
        <a href="{{ route('reviews.index') }}" class="menu-link">
          <i class="menu-icon tf-icons bx bx-star"></i>
          <div class="text-truncate">Reviews</div>
        </a>
      </li> 
    @endcan

    <!-- Orders -->
    @can('Manage Orders')
      <li class="menu-item {{ Route::is('orders.*') ? 'active' : '' }}">
        <a href="{{ route('orders.index') }}" class="menu-link">
          <i class="menu-icon tf-icons bx bx-cart"></i>
          <div class="text-truncate">Orders</div>
        </a>
      </li> 
    @endcan

    <!-- User Management -->
    @can("View Users")
      <li class="menu-item {{ Route::is('users.*')  || Route::is('roles.*') || Route::is('permissions.*') ? 'open' : '' }}">
        <a href="javascript:void(0);" class="menu-link menu-toggle">
          <i class="menu-icon tf-icons bx bx-user-circle"></i>
          <div class="text-truncate">User Management</div>
        </a>
        <ul class="menu-sub">
          @can('View Users')
          <li class="menu-item {{ Route::is('users.*') ? 'active' : '' }}">
            <a href="{{ route('users.index') }}" class="menu-link">
              <i class="bx bx-user"></i>
              <div class="text-truncate">Users</div>
            </a>
          </li>
          @endcan

          @can('View Roles')
          <li class="menu-item {{ Route::is('roles.*') ? 'active' : '' }}">
            <a href="{{ route('roles.index') }}" class="menu-link">
              <i class="bx bx-shield-quarter"></i>
              <div class="text-truncate">Roles</div>
            </a>
          </li>
          @endcan

          <li class="menu-item {{ Route::is('permissions.*') ? 'active' : '' }}">
            <a href="{{ route('permissions.index') }}" class="menu-link">
              <i class="bx bx-lock-alt"></i>
              <div class="text-truncate">Permissions</div>
            </a>
          </li>
        </ul>
      </li> 
    @endcan
      
  </ul>
</aside>