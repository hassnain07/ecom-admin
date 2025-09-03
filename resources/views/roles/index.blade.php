@extends('theme-layout.layout')
@extends('theme-layout.page-title')
@section('title', 'LMS | Roles')
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
        <div class="row">
          <div class="col-md-3 offset-9">
            @include('theme-layout.msgs')
          </div>
        </div>

        <!-- / Navbar -->

        <!-- Content wrapper -->
        <div class="content-wrapper">
          <!-- Content -->
          @include('roles.create')
          <div class="container-xxl flex-grow-1 container-p-y">
            
            <div class="card">
                <div class="row card-header pb-0">
                    <div class="col-md-6">
                        <h5>Roles</h5>
                    </div>
                    <div class="col-md-3 offset-3 d-flex">
                        {{-- @can('Add Roles') --}}
                        <button
                        type="button"
                        class="btn btn-primary"
                        data-bs-toggle="modal"
                        data-bs-target="#createModal">
                          Add Role
                          </button>
                        {{-- @endcan --}}
                        @can('Delete Roles')
                        <button id="bulk-delete" class="btn btn-danger mx-2" disabled><i class="bx bx-trash me-1"></i></button>
                        @endcan
                    </div>
                </div>
                
                <div class="table table-responsive text-nowrap p-5 m-0">
                  <table class="table" id="datatable">
                    <thead>
                        <tr>
                            <th class="col-md-1 py-4"><input type="checkbox" class="form-check-input" id="select-all"></th>
                            <th class="col-md-2 py-4">Sr No:</th>
                            <th class="col-md-2 py-4">Role</th>
                            <th class="col-md-6 py-4">Permissions</th>
                            <th class="col-md-2 py-4">Actions</th>
                        </tr>
                    </thead>
                    <tbody class="table-border-bottom-0">
                    </tbody>
                </table>
                
                
                </div>
              </div>
          </div>
          <!-- / Content -->


          <div class="modal fade" id="editModal" tabindex="-1" aria-hidden="true">
            <div class="modal-dialog modal-lg" role="document">
              <div class="modal-content">
                <div class="modal-header">
                  <h5 class="modal-title" id="exampleModalLabel3">Edit Roles</h5>
                  <button
                    type="button"
                    class="btn-close"
                    data-bs-dismiss="modal"
                    aria-label="Close"></button>
                </div>
                <form id="editRoleForm" action="" method="post">
                  @csrf
                  @method('put')
                  <div class="modal-body">
                      <!-- Modal content will be loaded via AJAX -->
                  </div>
                  <div class="modal-footer">
                      <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal">
                          Close
                      </button>
                      <button type="submit" class="btn btn-primary mx-3">Save Changes</button>
                  </div>
              </form>              
                </div>
              </div>
            </div>
        

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

  @include('theme-layout.confirmDeleteModals')
 


    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

  <script>
     window.permissions = @json($permissions);
$(document).on('click', '.edit-role', function (e) {
    e.preventDefault();

    var roleId = $(this).data('id');

    $.ajax({
        url: '/roles/' + roleId + '/edit',
        type: 'GET',
        success: function (response) {
            // Populate the modal with the response data
            $('#editRoleForm').attr('action', '/roles/' + roleId);
            $('#editRoleForm .modal-body').html(response);

            // Show the modal
            $('#editModal').modal('show');
        },
        error: function (xhr) {
            console.error(xhr.responseText);
        }
    });
});



$(document).ready(function () {
    // Define table variable in the global scope
    window.table = $("#datatable").DataTable({
        processing: true,
        serverSide: true,
        order: [[0, "desc"]],
        ajax: "{{ url('roles-data') }}",
        columns: [
            { 
                data: 'id', 
                name: 'checkbox', 
                orderable: false, 
                searchable: false, 
                render: function (data, type, full, meta) {
                    return '<input type="checkbox" class="form-check-input user-checkbox" value="' + data + '">';
                }
            },
            { data: "id", name: "id" },           // Sr No:
            { data: "name", name: "name" },       // Role
            { data: "permissions", name: "permissions", orderable: false, searchable: false },  // Permissions
            { data: "action", name: "action", orderable: false, searchable: false }  // Actions
        ],
        pagingType: "full_numbers",
        language: {
            lengthMenu: "Show _MENU_ records per page"
        },
        responsive: true,  // Make table responsive
        autoWidth: false   // Disable automatic column width calculation
    });
});

$(document).on('click', '.delete-role', function() {
    var roleId = $(this).data('id');
    var formAction = '{{ route("roles.destroy", ":id") }}'; // Placeholder route
    formAction = formAction.replace(':id', roleId); // Replace with actual role ID
    $('#deleteForm').attr('action', formAction); // Set the form action dynamically
});

// Handle Select All checkbox
$('#select-all').on('click', function() {
    let rows = window.table.rows({ 'search': 'applied' }).nodes();
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
                url: '{{ route("roles.bulkDelete") }}',  // Route for bulk delete
                type: 'POST',
                data: {
                    ids: selectedIds,
                    _token: '{{ csrf_token() }}'
                },
                success: function(response) {
                    // Reload the DataTable after deletion
                    window.table.ajax.reload();  
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
                                Roles Deleted Successfully
                            </div>
                        </div>
                    `;

                    // Append the toast to the body
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


</script>
@endsection