@extends('theme-layout.layout')
@extends('theme-layout.page-title')
@section('title', 'Categories | Edit')
@section('content')
<div class="layout-wrapper layout-content-navbar">
  <div class="layout-container">
    @include('theme-layout.sideBar')
    
    <div class="layout-page">
      @include('theme-layout.navBar')
      @include('theme-layout.msgs')

      <div class="content-wrapper">
        <div class="container-xxl flex-grow-1 container-p-y">

          <div class="row">
            <div class="col-xxl">
              <div class="card mb-6">
                <div class="card-header d-flex align-items-center justify-content-between">
                  <h5 class="mb-0">Edit Category</h5>
                  <a href="{{ route('categories.index') }}" class="btn btn-primary">Back</a>
                </div>

                <div class="card-body">
                  <form action="{{ route('categories.update', $category->id) }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    @method('PUT')

                    {{-- Category Name --}}
                    <div class="row mb-6">
                      <label class="col-sm-2 col-form-label" for="category_name">Category Name</label>
                      <div class="col-sm-10">
                        <div class="input-group input-group-merge">
                          <input
                            type="text"
                            class="form-control @error('category_name') is-invalid @enderror"
                            id="category_name"
                            name="category_name"
                            placeholder="Enter category name"
                            value="{{ old('category_name', $category->category_name) }}"
                            required
                          />
                        </div>
                        @error('category_name')
                          <div class="invalid-feedback d-block">{{ $message }}</div>
                        @enderror
                      </div>
                    </div>

                    {{-- Parent Category --}}
                    <div class="row mb-6">
                      <label class="col-sm-2 col-form-label" for="parent_id">Parent Category</label>
                      <div class="col-sm-10">
                        <div class="input-group input-group-merge">
                          <select
                            class="form-control @error('parent_id') is-invalid @enderror"
                            id="parent_id"
                            name="parent_id"
                          >
                            <option value="" disabled {{ !$category->parent_id ? 'selected' : '' }}>Select Parent Category</option>
                            @foreach($parentCategories as $parent)
                              <option value="{{ $parent->id }}" 
                                {{ old('parent_id', $category->parent_id) == $parent->id ? 'selected' : '' }}>
                                {{ $parent->name }}
                              </option>
                            @endforeach
                          </select>
                        </div>
                        @error('parent_id')
                          <div class="invalid-feedback d-block">{{ $message }}</div>
                        @enderror
                      </div>
                    </div>

                    <div class="row justify-content-end">
                      <div class="col-sm-10">
                        <button type="submit" class="btn btn-primary">Save</button>
                      </div>
                    </div>
                  </form>
                </div>

              </div>
            </div>
          </div>
        </div>
        <div class="content-backdrop fade"></div>
      </div>
    </div>
  </div>
</div>

<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
@endsection
