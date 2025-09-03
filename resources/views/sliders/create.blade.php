@extends('theme-layout.layout')
@extends('theme-layout.page-title')
@section('title', 'Sliders | Create')
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
                      <h5 class="mb-0">Add Slider</h5>
                      <a href="{{route('sliders.index')}}" class="btn btn-primary">Back</a>
                    </div>
                    <div class="card-body">
                      <form action="{{route('sliders.store')}}" method="POST" enctype="multipart/form-data">
                        @csrf
                        <div class="row mb-6">
                          <label class="col-sm-2 col-form-label" for="basic-icon-default-fullname">Slider Image</label>
                          <div class="col-sm-10">
                            <div class="input-group input-group-merge">
                             
                              <input
                                type="file"
                                class="form-control"
                                id="basic-icon-default-fullname"
                                name="sliderImg"
                                placeholder="John Doe"
                                aria-label="John Doe"
                                aria-describedby="basic-icon-default-fullname2"
                                required />
                            </div>
                          </div>
                        </div>


                        <div class="row mb-3">
                            <label class="col-sm-2 col-form-label" for="editor">Slider Description</label>
                            <div class="col-sm-10">
                              <textarea id="editor" class="form-control" name="sliderTxt"  rows="6"></textarea>
                            </div>
                        </div>

                        <div class="row justify-content-end">
                          <div class="col-sm-10">
                            <button type="submit" class="btn btn-primary">Add Slider</button>
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