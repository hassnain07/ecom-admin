@extends('theme-layout.layout')
@extends('theme-layout.page-title')
@section('title', 'LMS | Permissions')
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
          @include('permissions.create')
          <div class="container-xxl flex-grow-1 container-p-y">
            
            <div class="card">
                <div class="row card-header pb-0">
                    <div class="col-md-6">
                        <h5>Permissions</h5>
                    </div>
                    <div class="col-md-1 offset-5">
                        <button
                        type="button"
                        class="btn btn-primary"
                        data-bs-toggle="modal"
                        data-bs-target="#basicModal">
                          Add 
                      </button>
                    </div>
                </div>
                
                <div class="table-responsive text-nowrap p-5 m-0">
                  <table class="table table-hover datatable" id="datatable">
                    <thead>
                      <tr class="">
                        <th class="col-md-2 py-4">Sr No:</th>
                        <th class="col-md-8 py-4">Permission</th>
                        <th class="col-md-2 py-4">Actions</th>
                      </tr>
                    </thead>
                    <tbody>

                      @if ($permissions->isNotEmpty())
                        @foreach ($permissions as $permission)
                            @include('permissions.edit')
                        @endforeach
                      @endif
                        
                      
                      
                    </tbody>
                  </table>
                </div>
              </div>
          </div>
          <!-- / Content -->

        

        
          @include('theme-layout.confirmDeleteModals')
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

  <script>
    $(document).on('click', '.delete-permission', function() {
    var permissionId = $(this).data('id');
    var formAction = '{{ route("permissions.destroy", ":id") }}'; // Placeholder route
    formAction = formAction.replace(':id', permissionId); // Replace with actual permission ID
    $('#deleteForm').attr('action', formAction); // Set the form action dynamically
});

  $(document).ready(function () {
    $("#datatable").DataTable({
        processing: true,
        serverSide: true,
        order: [[0, "desc"]],
        ajax: "{{ url('permissions-data') }}",
        columns: [
            { data: 'DT_RowIndex', name: 'DT_RowIndex', title: 'Sr No', orderable: false, searchable: false },
            { data: "name", name: "name" },  // Permission
            { 
                data: "action", 
                name: "action", 
                orderable: false, 
                searchable: false 
            }  // Actions
        ],
          pagingType:"full_numbers",
          language: {
            lengthMenu: "Show  _MENU_  records per page",
        },
        responsive: true,  // Make table responsive
        autoWidth: false   // Disable automatic column width calculation
    });
});

</script>
@endsection