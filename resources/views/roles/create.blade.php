<div class="modal fade" id="createModal" tabindex="-1" aria-hidden="true">
  <div class="modal-dialog modal-lg" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel3">Roles</h5>
        <button
          type="button"
          class="btn-close"
          data-bs-dismiss="modal"
          aria-label="Close"></button>
      </div>
      <form action="{{ route('roles.store') }}" method="post">
        @csrf
      <div class="modal-body">
        <div class="row">
          <div class="col-md-12 mb-6">
            <label for="nameLarge" class="form-label">Name</label>
            <input type="text" id="nameLarge" name="name" class="form-control" placeholder="Enter Name" required/>
          </div>
        </div>
        <h5>Permissions</h5>
        <div class="row">
          @if ($permissions->isNotEmpty())
             @foreach ($permissions as $permission)
             <div class="col-md-2">
              <div class="form-check">
                <input class="form-check-input" name="permissions[]" type="checkbox" value="{{ $permission->name }}" id="defaultCheck{{ $permission->id }}" />
                <label class="form-check-label" for="defaultCheck{{ $permission->id }}"> {{ $permission->name }} </label>
              </div>
            </div> 
             @endforeach
          @endif
          
        </div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal">
          Close
        </button>
        <button type="submit" class="btn btn-primary mx-3">Add Role</button>
      </div>
    </form>
    </div>
  </div>
</div>