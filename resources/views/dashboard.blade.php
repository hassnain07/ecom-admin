@extends('theme-layout.layout')
@extends('theme-layout.page-title')
@section('title', 'Admin | Dashboard')

@section('content')
<div class="layout-wrapper layout-content-navbar">
  <div class="layout-container">
    @include('theme-layout.sideBar')
    <div class="layout-page">
      @include('theme-layout.navBar')

      <div class="content-wrapper">
        <div class="container-xxl flex-grow-1 container-p-y">

          <!-- KPI Cards -->
          <div class="row">
              @if($isAdmin)
                <div class="col-md-2 mb-3">
                    <div class="card text-center shadow-sm">
                    <div class="card-body">
                        <h5 class="card-title">Stores</h5>
                        <h2>{{ $totalStores }}</h2>
                    </div>
                    </div>
                </div>
              @endif

              @if (auth()->user()->hasRole('admin'))
               <div class="col-md-12 mb-4">
                <div class="card shadow-sm">
                  <div class="card-header">Pending Approval Stores</div>
                  <div class="card-body">
                    <table class="table table-sm">
                      <thead>
                        <tr>
                          <th>Name</th>
                          <th>Owner</th>
                          <th>Email</th>
                          <th>Created At</th>
                          <th>Action</th>
                        </tr>
                      </thead>
                      <tbody>
                        @forelse($pendingStores as $store)
                          <tr>
                            <td>{{ $store->name }}</td>
                            <td>{{ $store->owner_name }}</td>
                            <td>{{ $store->owner_email }}</td>
                            <td>{{ \Carbon\Carbon::parse($store->created_at)->format('d M, Y') }}</td>
                            <td>
                              <form action="{{ route('stores.approve', $store->id) }}" method="POST">
                                @csrf
                                <button type="submit" class="btn btn-success btn-sm">Approve</button>
                              </form>
                            </td>
                          </tr>
                        @empty
                          <tr>
                            <td colspan="5" class="text-center">No pending stores found</td>
                          </tr>
                        @endforelse
                      </tbody>
                    </table>
                  </div>
                </div>
              </div>
              @endif
           @if (auth()->user()->hasRole('Vendor'))
            <div class="col-md-2 mb-3">
              <div class="card text-center shadow-sm">
                <div class="card-body">
                  <h5 class="card-title">Products</h5>
                  <h2>{{ $totalProducts }}</h2>
                </div>
              </div>
            </div>
            <div class="col-md-2 mb-3">
              <div class="card text-center shadow-sm">
                <div class="card-body">
                  <h5 class="card-title">Orders</h5>
                  <h2>{{ $totalOrders }}</h2>
                </div>
              </div>
            </div>
            <div class="col-md-2 mb-3">
              <div class="card text-center shadow-sm">
                <div class="card-body">
                  <h5 class="card-title">Customers</h5>
                  <h2>{{ $totalUsers }}</h2>
                </div>
              </div>
            </div>
            <div class="col-md-2 mb-3">
              <div class="card text-center shadow-sm">
                <div class="card-body">
                  <h5 class="card-title">Revenue</h5>
                  <h2>Rs {{ number_format($totalRevenue,2) }}</h2>
                </div>
              </div>
            </div>
            <div class="col-md-2 mb-3">
              <div class="card text-center shadow-sm">
                <div class="card-body">
                  <h5 class="card-title">Avg Rating</h5>
                  <h2>{{ number_format($averageRating,1) }}/5</h2>
                </div>
              </div>
            </div>
           @endif
          </div>

          @if (auth()->user()->hasRole('Vendor'))
              <!-- Charts -->
          <div class="row">
            <div class="col-md-6 mb-4">
              <div class="card shadow-sm">
                <div class="card-header">Sales Trend</div>
                <div class="card-body">
                  <canvas id="salesTrendChart"></canvas>
                </div>
              </div>
            </div>
            <div class="col-md-6 mb-4">
              <div class="card shadow-sm">
                <div class="card-header">Orders by Status</div>
                <div class="card-body">
                  <canvas id="ordersStatusChart"></canvas>
                </div>
              </div>
            </div>
          </div>

          <!-- Tables -->
          <div class="row">
            <div class="col-md-6 mb-4">
              <div class="card shadow-sm">
                <div class="card-header">Recent Orders</div>
                <div class="card-body">
                  <table class="table table-sm">
                    <thead>
                      <tr>
                        <th>Customer</th>
                        <th>Total</th>
                        <th>Status</th>
                      </tr>
                    </thead>
                    <tbody>
                      @foreach($recentOrders as $order)
                      <tr>
                        <td>{{ $order->customer_name }}</td>
                        <td>${{ number_format($order->total,2) }}</td>
                        <td><span class="badge bg-info">{{ $order->status }}</span></td>
                      </tr>
                      @endforeach
                    </tbody>
                  </table>
                </div>
              </div>
            </div>

            <div class="col-md-6 mb-4">
              <div class="card shadow-sm">
                <div class="card-header">Top Rated Products</div>
                <div class="card-body">
                  <ul class="list-group">
                    @foreach($topRatedProducts as $product)
                    <li class="list-group-item d-flex justify-content-between align-items-center">
                      {{ $product->name }}
                      <span class="badge bg-success">{{ number_format($product->avg_rating,1) }}/5</span>
                    </li>
                    @endforeach
                  </ul>
                </div>
              </div>
            </div>
          </div>
          @endif

        </div>
        <div class="content-backdrop fade"></div>
      </div>
    </div>
  </div>
  <div class="layout-overlay layout-menu-toggle"></div>
</div>

<!-- Chart.js -->
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
  const salesCtx = document.getElementById('salesTrendChart');
  new Chart(salesCtx, {
    type: 'line',
    data: {
      labels: {!! json_encode($salesMonths) !!},
      datasets: [{
        label: 'Sales',
        data: {!! json_encode($salesTotals) !!},
        borderColor: 'blue',
        fill: false
      }]
    }
  });

  const ordersCtx = document.getElementById('ordersStatusChart');
  new Chart(ordersCtx, {
    type: 'doughnut',
    data: {
      labels: {!! json_encode(array_keys($ordersByStatus)) !!},
      datasets: [{
        data: {!! json_encode(array_values($ordersByStatus)) !!},
        backgroundColor: ['#0d6efd', '#198754', '#dc3545', '#ffc107']
      }]
    }
  });
</script>
@endsection
