@extends('theme-layout.layout')
@extends('theme-layout.page-title')
@section('title', 'RTS | Orders')
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
                        <h5>Orders</h5>
                    </div>
                </div>
                
                <div class="table-responsive text-nowrap p-5 m-0">
                    <table class="table table-hover datatable" id="datatable">
                        <thead>
                            <tr>
                                <th class="col-md-1 py-4">Sr No:</th>
                                <th class="col-md-2 py-4">Customer Name</th>
                                {{-- <th class="col-md-2 py-4">Email</th> --}}
                                <th class="col-md-2 py-4">Phone</th>
                                <th class="col-md-2 py-4">Store</th>
                                <th class="col-md-1 py-4">Total</th>
                                <th class="col-md-1 py-4">Status</th>
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
    

  </div>

   @include('theme-layout.confirmDeleteModals')

   <div class="modal" id="modalCenter" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="modalCenterTitle">Confirm Deletion</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <p>Are you sure you want to delete the selected orders?</p>
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

$(document).on('click', '.change-status', function () {
    let orderId = $(this).data('id');
    let status = $(this).data('status');

    $.ajax({
        url: '/orders/' + orderId + '/status',
        type: 'POST',
        data: {
            _token: '{{ csrf_token() }}',
            status: status
        },
        success: function (response) {
            if (response.success) {
                alert(response.message);
                $('#datatable').DataTable().ajax.reload(null, false);
            }
        },
        error: function (xhr, status, error) {
            console.log(xhr); // logs the full response object
            let message = "Error: " + xhr.status + " " + error + "\n\n";
            if (xhr.responseText) {
                message += xhr.responseText; // shows Laravel error/exception text
            }
            alert(message);
        }
    });
});

$(document).ready(function () {
    let table = $("#datatable").DataTable({
        processing: true,
        serverSide: true,
        order: [[1, "desc"]],
        ajax: "{{ url('orders-data') }}", // Fetching orders data via AJAX
        columns: [
          
            { data: "id", name: "id" },  
            { data: "customer_name", name: "customer_name" },  
            // { data: "email", name: "email" },  
            { data: "phone", name: "phone" },  
            { data: "store_name", name: "store_name" },  
            { data: "total", name: "total" },  
            { data: "status", name: "status" },  
            { 
                data: "action", 
                name: "action", 
                orderable: false, 
                searchable: false 
            }
        ],
        pagingType: "full_numbers",
        language: {
            lengthMenu: "Show _MENU_ records per page"
        },
        responsive: true,
        autoWidth: false
    });

    // Select All Checkbox
    $('#select-all').on('click', function() {
        let rows = table.rows({ 'search': 'applied' }).nodes();
        $('input[type="checkbox"]', rows).prop('checked', this.checked);
        toggleDeleteButton();
    });

    // Single row checkbox
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

});
</script>
@endsection
