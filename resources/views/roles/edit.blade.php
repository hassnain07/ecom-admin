@if (isset($editRole))
<div class="row">
    <div class="col-md-12 mb-6">
        <label for="nameLarge" class="form-label">Name</label>
        <input type="text" id="nameLarge" name="name" class="form-control" value="{{ $editRole->name }}" required/>
    </div>
</div>
<h5>Permissions</h5>


<div class="row">
    @foreach ($permissions as $permission)
    <div class="col-md-2">
        <div class="form-check">
            <input class="form-check-input" name="permissions[]" type="checkbox" value="{{ $permission->name }}" id="defaultCheck{{ $permission->id }}"
                   @if($hasPermission->contains($permission->name)) checked @endif/>
            <label class="form-check-label" for="defaultCheck{{ $permission->id }}"> {{ $permission->name }} </label>
        </div>
    </div> 
    @endforeach
</div>
@endif
