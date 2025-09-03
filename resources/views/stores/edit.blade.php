@extends('theme-layout.layout')
@extends('theme-layout.page-title')
@section('title', 'Stores | Edit')
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
        <div class="container-xxl flex-grow-1 container-p-y">
          <div class="row">
            <div class="col-xxl">
              <div class="card mb-6">
                <div class="card-header d-flex align-items-center justify-content-between">
                  <h5 class="mb-0">Edit Store</h5>
                  <a href="{{ route('stores.index') }}" class="btn btn-primary">Back</a>
                </div>
                <div class="card-body">
                  <form action="{{ route('stores.update',$store->id) }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    @method('put')

                    {{-- Store Name --}}
                    <div class="row mb-3">
                      <label class="col-sm-2 col-form-label">Store Name</label>
                      <div class="col-sm-10">
                        <input type="text" 
                          name="name" 
                          class="form-control @error('name') is-invalid @enderror"
                          value="{{ old('name',$store->name) }}" 
                          required>
                        @error('name') <div class="invalid-feedback">{{ $message }}</div> @enderror
                      </div>
                    </div>

                    {{-- Description --}}
                    <div class="row mb-3">
                      <label class="col-sm-2 col-form-label">Description</label>
                      <div class="col-sm-10">
                        <textarea name="description" 
                          class="form-control @error('description') is-invalid @enderror"
                          rows="3">{{ old('description',$store->description) }}</textarea>
                        @error('description') <div class="invalid-feedback">{{ $message }}</div> @enderror
                      </div>
                    </div>

                    {{-- Logo --}}
                    <div class="row mb-3">
                      <label class="col-sm-2 col-form-label">Logo</label>
                      <div class="col-sm-10">
                        <input type="file" name="logo" class="form-control">
                      </div>
                    </div>

                    {{-- Banner --}}
                    <div class="row mb-3">
                      <label class="col-sm-2 col-form-label">Banner</label>
                      <div class="col-sm-10">
                        <input type="file" name="banner" class="form-control">
                      </div>
                    </div>

                    {{-- Contact Phone --}}
                    <div class="row mb-3">
                      <label class="col-sm-2 col-form-label">Phone</label>
                      <div class="col-sm-10">
                        <input type="text" 
                          name="contact_phone" 
                          class="form-control @error('contact_phone') is-invalid @enderror"
                          value="{{ old('contact_phone',$store->contact_phone) }}">
                        @error('contact_phone') <div class="invalid-feedback">{{ $message }}</div> @enderror
                      </div>
                    </div>

                    {{-- Address --}}
                    <div class="row mb-3">
                      <label class="col-sm-2 col-form-label">Address</label>
                      <div class="col-sm-10">
                        <input type="text" 
                          name="contact_address" 
                          class="form-control @error('contact_address') is-invalid @enderror"
                          value="{{ old('contact_address',$store->contact_address) }}">
                        @error('contact_address') <div class="invalid-feedback">{{ $message }}</div> @enderror
                      </div>
                    </div>

                    {{-- Postal Code --}}
                    <div class="row mb-3">
                      <label class="col-sm-2 col-form-label">Postal Code</label>
                      <div class="col-sm-10">
                        <input type="text" 
                          name="contact_postal_code" 
                          class="form-control @error('contact_postal_code') is-invalid @enderror"
                          value="{{ old('contact_postal_code',$store->contact_postal_code) }}">
                        @error('contact_postal_code') <div class="invalid-feedback">{{ $message }}</div> @enderror
                      </div>
                    </div>

                    {{-- Shipping Policy --}}
                    <div class="row mb-3">
                      <label class="col-sm-2 col-form-label">Shipping Policy</label>
                      <div class="col-sm-10">
                        <textarea name="shipping_policy" 
                          class="form-control @error('shipping_policy') is-invalid @enderror"
                          rows="3">{{ old('shipping_policy',$store->shipping_policy) }}</textarea>
                        @error('shipping_policy') <div class="invalid-feedback">{{ $message }}</div> @enderror
                      </div>
                    </div>

                    {{-- Return Policy --}}
                    <div class="row mb-3">
                      <label class="col-sm-2 col-form-label">Return Policy</label>
                      <div class="col-sm-10">
                        <textarea name="return_policy" 
                          class="form-control @error('return_policy') is-invalid @enderror"
                          rows="3">{{ old('return_policy',$store->return_policy) }}</textarea>
                        @error('return_policy') <div class="invalid-feedback">{{ $message }}</div> @enderror
                      </div>
                    </div>

                    {{-- Privacy Policy --}}
                    <div class="row mb-3">
                      <label class="col-sm-2 col-form-label">Privacy Policy</label>
                      <div class="col-sm-10">
                        <textarea name="privacy_policy" 
                          class="form-control @error('privacy_policy') is-invalid @enderror"
                          rows="3">{{ old('privacy_policy',$store->privacy_policy) }}</textarea>
                        @error('privacy_policy') <div class="invalid-feedback">{{ $message }}</div> @enderror
                      </div>
                    </div>

                    {{-- Status --}}
                    <div class="row mb-3">
                      <label class="col-sm-2 col-form-label">Active</label>
                      <div class="col-sm-10">
                        <input type="checkbox" class="form-check" name="is_active" value="1" {{ old('is_active', $store->is_active) ? 'checked' : '' }}>
                      </div>
                    </div>

                    {{-- Submit --}}
                    <div class="row justify-content-end">
                      <div class="col-sm-10">
                        <button type="submit" class="btn btn-primary">Save Store</button>
                      </div>
                    </div>

                  </form>
                </div>
              </div>
            </div>
          </div>
          <div class="content-backdrop fade"></div>
        </div>
      </div>
    </div>
    <div class="layout-overlay layout-menu-toggle"></div>
  </div>
</div>
@endsection
