@extends('theme-layout.layout')
@extends('theme-layout.page-title')
@section('title', 'RTS | Blogs')
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
            
            <div class="card">
                <div class="row card-header">
                    <div class="col-md-6">
                        <h5>Categories</h5>
                    </div> 
                </div>
                
                <div class="table-responsive text-nowrap p-5 m-0">
                    <table class="table table-hover datatable" id="datatable">
                        <thead>
                            <tr>
                                <th>Sr No</th>
                                <th>Product</th>
                                <th>User</th>
                                <th>Subject</th>
                                <th>Rating</th>
                                <th>Review</th>
                                <th>Date</th>
                            </tr>
                        </thead>
                        <tbody>
                            <!-- Data will be populated via DataTables AJAX -->
                        </tbody>
                    </table>
                    
                    <!-- Bulk delete button -->
                    
                    
                    
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

   @include('theme-layout.confirmDeleteModals')

   <div class="modal" id="modalCenter" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="modalCenterTitle">Confirm Deletion</h5>
                <button
                    type="button"
                    class="btn-close"
                    data-bs-dismiss="modal"
                    aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <p>Are you sure you want to delete the selected users?</p>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal">
                    Cancel
                </button>
                <button type="button" class="btn btn-danger mx-3" id="confirmDelete">OK</button>
            </div>
        </div>
    </div>
</div>


 


    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>




<script>

$(document).ready(function () {
    let table = $("#datatable").DataTable({
        processing: true,
        serverSide: true,
        order: [[6, "desc"]],
        ajax: "{{ url('reviews-data') }}",
        columns: [
            { data: "DT_RowIndex", name: "DT_RowIndex", orderable: false, searchable: false },
            { data: "product_name", name: "product_name" },
            { data: "user_name", name: "user_name" },
            { data: "subject", name: "subject" },
            { data: "rating", name: "rating" },
            { data: "review", name: "review" },
            { data: "created_at", name: "created_at" },
        ],
        pagingType: "full_numbers",
        language: {
            lengthMenu: "Show _MENU_ records per page"
        },
        responsive: true,
        autoWidth: false
    });
});

  </script>
@endsection