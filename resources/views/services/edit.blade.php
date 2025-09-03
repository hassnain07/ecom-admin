@extends('theme-layout.layout')
@extends('theme-layout.page-title')
@section('title', 'Services | Edit')
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
                      <h5 class="mb-0">Add Service</h5>
                      <a href="{{route('services.index')}}" class="btn btn-primary">Back</a>
                    </div>
                    <div class="card-body">
                      <form action="{{route('services.update',$service->id)}}" method="POST" enctype="multipart/form-data">
                        @csrf
                        @method('put')
                        <div class="row mb-6">
                          <label class="col-sm-2 col-form-label" for="basic-icon-default-fullname">Service Image</label>
                          <div class="col-sm-10">
                            <div class="input-group input-group-merge">
                              <input
                                type="file"
                                class="form-control"
                                id="basic-icon-default-fullname"
                                name="image"
                                placeholder="John Doe"
                                aria-label="John Doe"
                                aria-describedby="basic-icon-default-fullname2"
                                 />
                            </div>
                          </div>
                        </div>
                        <div class="row mb-6">
                          <label class="col-sm-2 col-form-label" for="basic-icon-default-fullname">Service Name</label>
                          <div class="col-sm-10">
                            <div class="input-group input-group-merge">
                             
                              <input
                                type="text"
                                class="form-control"
                                id="basic-icon-default-fullname"
                                name="name"
                                placeholder="John Doe"
                                aria-label="John Doe"
                                aria-describedby="basic-icon-default-fullname2"
                                value="{{$service->name}}"
                                required />
                            </div>
                          </div>
                        </div>
                        <div class="row mb-6">
                          <label class="col-sm-2 col-form-label" for="basic-icon-default-fullname">Short Description</label>
                          <div class="col-sm-10">
                            <div class="input-group input-group-merge">
                              <input
                                type="text"
                                class="form-control"
                                id="basic-icon-default-fullname"
                                name="short_desc"
                                value="{{$service->short_desc}}"
                                placeholder="John Doe"
                                aria-label="John Doe"
                                aria-describedby="basic-icon-default-fullname2"
                                required />
                            </div>
                          </div>
                        </div>
                        <div class="row mb-6">
                          <label class="col-sm-2 col-form-label" for="basic-icon-default-fullname">Service Type</label>
                          <div class="col-sm-10">
                            <div class="input-group input-group-merge">
                              <select name="service_type" id="" class="form-control" required>
                                <option value="">Select Service Type</option>
                                <option value="Taxation" {{ $service->service_type == "Taxation" ? 'selected' : ""}}>Taxation</option>
                                <option value="Corporate Affairs" {{ $service->service_type == "Corporate Affairs" ? 'selected' : ""}}>Corporate Affairs</option>
                                <option value="T.M Affairs" {{ $service->service_type == "T.M Affairs" ? 'selected' : ""}}>T.M Affairs</option>
                                <option value="Financial Affairs" {{ $service->service_type == "Financial Affairs" ? 'selected' : ""}}>Financial Affairs</option>
                                <option value="Business Solutions" {{ $service->service_type == "Business Solutions" ? 'selected' : ""}}>Business Solutions</option>
                                <option value="Others" {{ $service->service_type == "Others" ? 'selected' : ""}}>Others</option>
                              </select>
                            </div>
                          </div>
                        </div>


                        <div class="row mb-3">
                            <label class="col-sm-2 col-form-label" for="editor">Long Description</label>
                            <div class="col-sm-10">
                              <textarea id="editor" class="form-control" name="long_desc"  rows="6" required>
                                {{$service->long_desc}}
                              </textarea>
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