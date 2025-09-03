@extends('theme-layout.layout')
@extends('theme-layout.page-title')
@section('title', 'RTS | Users')
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
                        <h5>Users</h5>
                    </div>
                    <div class="col-md-3 offset-3 d-flex" >
                        @can('Add Users')
                        <a href="{{route('users.create')}}" class="btn btn-primary">Add User</a>
                        @endcan
                        @can('Delete Users')
                        <button id="bulk-delete" class="btn btn-danger mx-2" disabled><i class="bx bx-trash me-1"></i></button>
                        @endcan
                    </div>

                    
                </div>
                
                <div class="table-responsive text-nowrap p-5 m-0">
                    <table class="table table-hover datatable" id="datatable">
                        <thead>
                            <tr>
                                <th class="col-md-1 py-4"><input type="checkbox" class="form-check-input" id="select-all"></th>
                                <th class="col-md-1 py-4">Sr No</th>
                                <th class="col-md-2 py-4">User</th>
                                <th class="col-md-2 py-4">Email</th>
                                <th class="col-md-3 py-4">Role</th>
                                <th class="col-md-2 py-4">Actions</th>
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

   <div class="modal fade" id="modalCenter" tabindex="-1" aria-hidden="true">
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



$(document).on('click', '.delete-button', function() {
    var userId = $(this).data('id');
    var formAction = '{{ route("users.destroy", ":id") }}'; // Placeholder route
    formAction = formAction.replace(':id', userId); // Replace the placeholder with the actual ID
    $('#deleteForm').attr('action', formAction); // Set the form action URL dynamically
});

$(document).ready(function () {
    let table = $("#datatable").DataTable({
        processing: true,
        serverSide: true,
        order: [[1, "desc"]],  // Adjust index because of the new checkbox column
        ajax: "{{ url('users-data') }}", // Fetching users data via AJAX
        columns: [
            { 
                data: 'id', 
                name: 'checkbox', 
                orderable: false, 
                searchable: false, 
                render: function (data, type, full, meta) {
                    return '<input type="checkbox" class="form-check-input user-checkbox" value="' + data + '">';
                }
            }, // Checkbox column
            { data: "id", name: "id" },  // Sr No
            { data: "name", name: "name" },  // User
            { data: "email", name: "email" },  // Email
            { data: "roles", name: "roles" },  // Role
            { 
                data: "action", 
                name: "action", 
                orderable: false, 
                searchable: false 
            }  // Actions
        ],
        pagingType: "full_numbers",
        language: {
            lengthMenu: "Show _MENU_ records per page"
        },
        responsive: true,
        autoWidth: false
    });

    // Handle Select All checkbox
    $('#select-all').on('click', function() {
        let rows = table.rows({ 'search': 'applied' }).nodes();
        $('input[type="checkbox"]', rows).prop('checked', this.checked);
        toggleDeleteButton(); // Enable/Disable bulk delete button
    });

    // Handle single row checkbox change
    $('#datatable tbody').on('change', '.user-checkbox', function() {
        if (!this.checked) {
            $('#select-all').prop('checked', false);
        }
        toggleDeleteButton(); // Enable/Disable bulk delete button
    });

    // Function to enable/disable bulk delete button
    function toggleDeleteButton() {
        let anyChecked = $('.user-checkbox:checked').length > 0;
        $('#bulk-delete').prop('disabled', !anyChecked);
    }

    // Handle bulk delete button click
    $('#bulk-delete').on('click', function () {
        let selectedIds = [];
        $('.user-checkbox:checked').each(function () {
            selectedIds.push($(this).val());
        });

        if (selectedIds.length > 0) {
            $('#modalCenter').modal('show');  // Show modal instead of alert

            // Handle the "OK" button click inside the modal
            $('#confirmDelete').off('click').on('click', function () {
                $.ajax({
                    url: '{{ route("users.bulkDelete") }}',  // Route for bulk delete
                    type: 'POST',
                    data: {
                        ids: selectedIds,
                        _token: '{{ csrf_token() }}'
                    },
                    success: function(response) {
                        // Reload the DataTable after deletion
                        table.ajax.reload();  
                        $('#bulk-delete').prop('disabled', true);  // Disable the bulk delete button
                        $('#select-all').prop('checked', false);   // Uncheck the "select all" checkbox
                        $('#modalCenter').modal('hide');  // Hide the modal after success

                        // Create and append the toast dynamically
                        let toastHTML = `
                            <div class="bs-toast toast fade show bg-success custom-toast" role="alert" aria-live="assertive" aria-atomic="true" data-bs-delay="5000" style="z-index: 10000; position: fixed; top: 20px; right: 20px;">
                                <div class="toast-header">
                                    <i class="bx bx-bell me-2"></i>
                                    <div class="me-auto fw-medium">Success</div>
                                    <button type="button" class="btn-close" data-bs-dismiss="toast" aria-label="Close"></button>
                                </div>
                                <div class="toast-body">
                                    Users Deleted Successfully
                                </div>
                            </div>
                        `;

                        // Append the toast to the body (or another appropriate container)
                        $('body').append(toastHTML);

                        // Show the toast using Bootstrap's toast method
                        $('.toast').toast('show');
                        },
                    error: function(xhr, status, error) {
                        alert('Something went wrong.');
                    }
                });
            });
        }
    });
});


  </script>
@endsection