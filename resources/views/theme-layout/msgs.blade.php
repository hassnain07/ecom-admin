@if(Session::has('error'))
    <div
        class="bs-toast toast fade show custom-toast bg-danger"
        role="alert"
        aria-live="assertive"
        aria-atomic="true"
        data-bs-delay="5000">
        <div class="toast-header">
            <i class="bx bx-bell me-2"></i>
            <div class="me-auto fw-medium">Error</div>
            <button type="button" class="btn-close" data-bs-dismiss="toast" aria-label="Close"></button>
        </div>
        <div class="toast-body">
            {{ Session::get('error') }}
        </div>
    </div>
    @elseif(Session::has('success'))
    <div
        class="bs-toast toast fade show bg-success custom-toast"
        role="alert"
        aria-live="assertive"
        aria-atomic="true"
        data-bs-delay="5000">
        <div class="toast-header">
            <i class="bx bx-bell me-2"></i>
            <div class="me-auto fw-medium">Success</div>
            <button type="button" class="btn-close" data-bs-dismiss="toast" aria-label="Close"></button>
        </div>
        <div class="toast-body">
            {{ Session::get('success') }}
        </div>
    </div>
@endif



@if ($errors->any())
    <div class="toast-container position-fixed top-0 end-0 p-3" style="z-index: 9999;">
        @foreach ($errors->all() as $error)
            <div
        class="bs-toast toast fade show bg-danger custom-toast"
        role="alert"
        aria-live="assertive"
        aria-atomic="true"
        data-bs-delay="5000">
        <div class="toast-header">
            <i class="bx bx-bell me-2"></i>
            <div class="me-auto fw-medium">Error</div>
            <small>Just now</small>
            <button type="button" class="btn-close" data-bs-dismiss="toast" aria-label="Close"></button>
        </div>
        <div class="toast-body">
            {{ $error }}
        </div>
       </div>
        @endforeach
    </div>
@endif

<style>
    .custom-toast {
        z-index: 1056; /* You can increase this value if needed */
        position: fixed; /* Ensure it's positioned above other elements */
        top: 20px; /* Adjust position as needed */
        right: 20px; /* Adjust position as needed */
    }
</style>

@if ($errors->any())
    <script>
        $(document).ready(function() {
            toastr.error('Please check the form for errors.');
        });
    </script>
@endif
