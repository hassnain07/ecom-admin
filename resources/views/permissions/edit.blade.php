
<div class="modal fade" id="basicModalEdit-{{$permission->id}}" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="exampleModalLabel1">Edit Permission</h5>
          <button
            type="button"
            class="btn-close"
            data-bs-dismiss="modal"
            aria-label="Close"></button>
        </div>
        <form action="{{route('permissions.update')}}" method="POST">
            @csrf
            @method('put')
        <div class="modal-body">
              <div class="row">
                <div class="col mb-6">
                  <label for="nameBasic" class="form-label">Permission Name</label>
                  <input type="text" name="name" id="nameBasic" value="{{$permission->name}}" class="form-control" placeholder="Enter Name" />
                  <input type="hidden" name="permission_id" value="{{$permission->id}}">
                </div>
              </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal">
                    Close
                </button>
                <button type="submit" class="btn btn-primary mx-3">Submit</button>
            </div>
        </form>
      </div>
    </div>
  </div>
