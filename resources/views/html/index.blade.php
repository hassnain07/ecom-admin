@extends('theme-layout.layout')
@extends('theme-layout.page-title')
@section('title', 'RTS | Dashboard')
@section('content')
    <!-- Layout wrapper -->
    <div class="layout-wrapper layout-content-navbar">
      <div class="layout-container">
        <!-- Menu -->
        @include('theme-layout.sideBar')
        <!-- / Menu -->
        
        <!-- Layout container -->
        <div class="layout-page">
          <!-- Navbar -->
          
          @include('theme-layout.navBar')

          <!-- / Navbar -->

          <!-- Content wrapper -->
          <div class="content-wrapper">
            <!-- Content -->

            <div class="container-xxl flex-grow-1 container-p-y">
              
              
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
    <!-- / Layout wrapper -->

    


    
@endsection