@extends('theme-layout.layout')
@extends('theme-layout.page-title')
@section('title', 'Admin | Product Statuses')
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
                        <h5>Product Statuses</h5>
                    </div>
                    <div class="col-md-3 offset-3 d-flex">
                        <a href="{{ route('product-status.create') }}" class="btn btn-primary">Assign Status</a>
                        <button id="bulk-delete" class="btn btn-danger mx-2" disabled>
                            <i class="bx bx-trash me-1"></i>
                        </button>
                    </div>
                </div>
                
                <div class="table-responsive text-nowrap p-5 m-0">
                    <table class="table table-hover datatable" id="datatable">
                        <thead>
                            <tr>
                                <th class="col-md-1 py-4"><input type="checkbox" class="form-check-input" id="select-all"></th>
                                <th class="col-md-1 py-4">Sr No:</th>
                                <th class="col-md-2 py-4">Product</th>
                                <th class="col-md-2 py-4">Status</th>
                                <th class="col-md-2 py-4">User</th>
                                <th class="col-md-2 py-4">Sale Price</th>
                                <th class="col-md-2 py-4">Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            <!-- Data will be populated via DataTables AJAX -->
                        </tbody>
                    </table>
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
    
  @include('theme-layout.confirmDeleteModals')

  <!-- Bulk delete confirmation modal -->
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
                <p>Are you sure you want to delete the selected product statuses?</p>
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
    var statusId = $(this).data('id');
    var formAction = '{{ route("product-status.destroy", ":id") }}';
    formAction = formAction.replace(':id', statusId);
    $('#deleteForm').attr('action', formAction);
});

$(document).ready(function () {
    let table = $("#datatable").DataTable({
        processing: true,
        serverSide: true,
        order: [[1, "desc"]],
        ajax: "{{ route('product-status.data') }}", // Route -> ProductStatusController@getProductStatuses
        columns: [
            { 
                data: 'id', 
                name: 'checkbox', 
                orderable: false, 
                searchable: false, 
                render: function (data) {
                    return '<input type="checkbox" class="form-check-input user-checkbox" value="' + data + '">';
                }
            },
            { data: "id", name: "id" },
            { data: "product", name: "product" },
            { data: "status", name: "status" },
            { data: "user", name: "user" },
            { data: "sale_price", name: "sale_price" },
            { data: "action", name: "action", orderable: false, searchable: false }
        ],
        pagingType: "full_numbers",
        language: {
            lengthMenu: "Show _MENU_ records per page"
        },
        responsive: true,
        autoWidth: false
    });

    // Handle Select All
    $('#select-all').on('click', function() {
        let rows = table.rows({ 'search': 'applied' }).nodes();
        $('input[type="checkbox"]', rows).prop('checked', this.checked);
        toggleDeleteButton();
    });

    // Handle single row checkbox
    $('#datatable tbody').on('change', '.user-checkbox', function() {
        if (!this.checked) {
            $('#select-all').prop('checked', false);
        }
        toggleDeleteButton();
    });

    function toggleDeleteButton() {
        let anyChecked = $('.user-checkbox:checked').length > 0;
        $('#bulk-delete').prop('disabled', !anyChecked);
    }

    // Bulk delete
    $('#bulk-delete').on('click', function () {
        let selectedIds = [];
        $('.user-checkbox:checked').each(function () {
            selectedIds.push($(this).val());
        });

        if (selectedIds.length > 0) {
            $('#modalCenter').modal('show');

            $('#confirmDelete').off('click').on('click', function () {
                $.ajax({
                    url: '{{ route("product-status.bulkDelete") }}',
                    type: 'POST',
                    data: {
                        ids: selectedIds,
                        _token: '{{ csrf_token() }}'
                    },
                    success: function(response) {
                        table.ajax.reload();
                        $('#bulk-delete').prop('disabled', true);
                        $('#select-all').prop('checked', false);
                        $('#modalCenter').modal('hide');

                        let toastHTML = `
                            <div class="bs-toast toast align-items-center text-bg-success border-0 custom-toast" 
                                role="alert" aria-live="assertive" aria-atomic="true">
                                <div class="d-flex">
                                <div class="toast-body">
                                    Product Statuses Deleted Successfully
                                </div>
                                <button type="button" class="btn-close btn-close-white me-2 m-auto" 
                                        data-bs-dismiss="toast" aria-label="Close"></button>
                                </div>
                            </div>
                        `;

                        $('body').append(toastHTML);
                        let toastEl = document.querySelector('.toast:last-child');
                        let toast = new bootstrap.Toast(toastEl, { delay: 5000 });
                        toast.show();
                    },
                    error: function() {
                        alert('Something went wrong.');
                    }
                });
            });
        }
    });
});
</script>
@endsection
