@extends('theme-layout.layout')
@extends('theme-layout.page-title')
@section('title', 'Blogs | Create')
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
                
                <!-- Basic with Icons -->
                <div class="col-xxl">
                  <div class="card mb-6">
                    <div class="card-header d-flex align-items-center justify-content-between">
                      <h5 class="mb-0">Add Category</h5>
                      <a href="{{route('categories.index')}}" class="btn btn-primary">Back</a>
                    </div>
                    <div class="card-body">
                    <form action="{{ route('categories.store') }}" method="POST" enctype="multipart/form-data">
                      @csrf
                      <div class="row mb-6">
                        <label class="col-sm-2 col-form-label" for="basic-icon-default-fullname">Category Name</label>
                        <div class="col-sm-10">
                          <div class="input-group input-group-merge">
                            <input
                              type="text"
                              class="form-control @error('category_name') is-invalid @enderror"
                              id="basic-icon-default-fullname"
                              name="category_name"
                              value="{{ old('category_name') }}"
                              placeholder="Enter category name"
                              required
                            />
                          </div>
                          @error('category_name')
                            <div class="invalid-feedback d-block">{{ $message }}</div>
                          @enderror
                        </div>
                      </div>

                      <div class="row justify-content-end">
                        <div class="col-sm-10">
                          <button type="submit" class="btn btn-primary">Add Category</button>
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
    

  </div>

 


    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>



    <script src="https://cdn.ckeditor.com/4.20.2/standard/ckeditor.js"></script>
    <script>
        CKEDITOR.replace('editor');
    </script>

@endsection