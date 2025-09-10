@extends('theme-layout.layout')
@extends('theme-layout.page-title')
@section('title', 'Product Status | Assign')
@section('content')
<div class="layout-wrapper layout-content-navbar">
    <div class="layout-container">
      <!-- Menu -->
      @include('theme-layout.sideBar')
      <!-- / Menu -->
      
      <!-- Layout container -->
      <div class="layout-page">
        <!-- Navbar -->
        @include('theme-layout.navBar')
        @include('theme-layout.msgs')
        <!-- / Navbar -->

        <!-- Content wrapper -->
        <div class="content-wrapper">
          <!-- Content -->
          <div class="container-xxl flex-grow-1 container-p-y">
            
            <div class="row">
                <!-- Assign Product Status -->
                <div class="col-xxl">
                  <div class="card mb-6">
                    <div class="card-header d-flex align-items-center justify-content-between">
                      <h5 class="mb-0">Assign Product Status</h5>
                      <a href="{{ route('product-status.index') }}" class="btn btn-primary">Back</a>
                    </div>
                    <div class="card-body">
                      <form action="{{ route('product-status.store') }}" method="POST">
                        @csrf

                        <!-- Product -->
                        <div class="row mb-6">
                          <label class="col-sm-2 col-form-label" for="product_id">Product</label>
                          <div class="col-sm-10">
                            <select 
                              name="product_id" 
                              id="product_id" 
                              class="form-control @error('product_id') is-invalid @enderror" 
                              required>
                              <option value="">Select a product</option>
                              @foreach($products as $product)
                                <option value="{{ $product->id }}" {{ old('product_id') == $product->id ? 'selected' : '' }}>
                                  {{ $product->name }}
                                </option>
                              @endforeach
                            </select>
                            @error('product_id')
                              <div class="invalid-feedback d-block">{{ $message }}</div>
                            @enderror
                          </div>
                        </div>

                        <!-- Status -->
                        <div class="row mb-6">
                          <label class="col-sm-2 col-form-label" for="status_id">Status</label>
                          <div class="col-sm-10">
                            <select 
                              name="status_id" 
                              id="status_id" 
                              class="form-control @error('status_id') is-invalid @enderror" 
                              required>
                              <option value="">Select a status</option>
                              @foreach($statuses as $status)
                                <option value="{{ $status->id }}" {{ old('status_id') == $status->id ? 'selected' : '' }}>
                                  {{ $status->name }}
                                </option>
                              @endforeach
                            </select>
                            @error('status_id')
                              <div class="invalid-feedback d-block">{{ $message }}</div>
                            @enderror
                          </div>
                        </div>

                        <!-- Sale Price -->
                        <div class="row mb-6">
                          <label class="col-sm-2 col-form-label" for="sale_price">Sale Price</label>
                          <div class="col-sm-10">
                            <input 
                              type="number" 
                              name="sale_price" 
                              id="sale_price"
                              class="form-control @error('sale_price') is-invalid @enderror"
                              value="{{ old('sale_price') }}"
                              step="0.01"
                              min="0"
                              placeholder="Enter sale price (optional)">
                            @error('sale_price')
                              <div class="invalid-feedback d-block">{{ $message }}</div>
                            @enderror
                          </div>
                        </div>

                        <!-- Submit -->
                        <div class="row justify-content-end">
                          <div class="col-sm-10">
                            <button type="submit" class="btn btn-primary">Assign Status</button>
                          </div>
                        </div>
                      </form>
                    </div>
                  </div>
                </div>
              </div>
          <!-- / Content -->
          <div class="content-backdrop fade"></div>
        </div>
        <!-- Content wrapper -->
      </div>
      <!-- / Layout page -->
    </div>

    <!-- Overlay -->
    <div class="layout-overlay layout-menu-toggle"></div>
  </div>
@endsection
