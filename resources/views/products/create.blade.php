@extends('theme-layout.layout')
@extends('theme-layout.page-title')
@section('title', 'Products | Create')
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
        <div class="container-xxl flex-grow-1 container-p-y">
          <div class="row">
            <div class="col-xxl">
              <div class="card mb-6">
                <div class="card-header d-flex align-items-center justify-content-between">
                  <h5 class="mb-0">Add Product</h5>
                  <a href="{{ route('products.index') }}" class="btn btn-primary">Back</a>
                </div>
                <div class="card-body">
                  <form action="{{ route('products.store') }}" method="POST" enctype="multipart/form-data">
                    @csrf

                    {{-- Product Name --}}
                    <div class="row mb-3">
                      <label class="col-sm-2 col-form-label">Product Name</label>
                      <div class="col-sm-10">
                        <input type="text" 
                          name="name" 
                          class="form-control @error('name') is-invalid @enderror"
                          value="{{ old('name') }}" 
                          required>
                        @error('name') <div class="invalid-feedback">{{ $message }}</div> @enderror
                      </div>
                    </div>

                    {{-- Description --}}
                    <div class="row mb-3">
                      <label class="col-sm-2 col-form-label">Description</label>
                      <div class="col-sm-10">
                        <textarea name="description" 
                          class="form-control @error('description') is-invalid @enderror"
                          rows="3">{{ old('description') }}</textarea>
                        @error('description') <div class="invalid-feedback">{{ $message }}</div> @enderror
                      </div>
                    </div>

                    {{-- Price --}}
                    <div class="row mb-3">
                      <label class="col-sm-2 col-form-label">Price</label>
                      <div class="col-sm-10">
                        <input type="number" step="0.01"
                          name="price" 
                          class="form-control @error('price') is-invalid @enderror"
                          value="{{ old('price') }}" required>
                        @error('price') <div class="invalid-feedback">{{ $message }}</div> @enderror
                      </div>
                    </div>

                    {{-- Category --}}
                <div class="row mb-3">
                    <label class="col-sm-2 col-form-label">Category</label>
                    <div class="col-sm-10">
                        <select name="category_id" class="form-control select2 @error('category_id') is-invalid @enderror" required>
                        <option value="">-- Select Category --</option>
                        @foreach($categories as $category)
                            <option value="{{ $category->id }}" {{ old('category_id') == $category->id ? 'selected' : '' }}>
                            {{ $category->category_name }}
                            </option>
                        @endforeach
                        </select>
                        @error('category_id') 
                        <div class="invalid-feedback">{{ $message }}</div> 
                        @enderror
                    </div>
                </div>

                    {{-- Product Images --}}
                    <div class="row mb-3">
                    <!-- Primary Image -->
                        <label class="col-sm-2 col-form-label">Primary Image</label>
                        <div class="col-sm-10">
                            <input type="file" name="primary_image" class="form-control" accept="image/*" onchange="previewPrimary(this)">
                            <small class="text-muted">Upload one primary image</small>
                            <div id="primaryPreview" class="mt-2"></div>
                        </div>
                    </div>

                    <div class="row mb-3">
                    <!-- Secondary Images -->
                    <label class="col-sm-2 col-form-label">Secondary Images</label>
                    <div class="col-sm-10">
                        <input type="file" name="secondary_images[]" class="form-control" accept="image/*" multiple onchange="previewSecondary(this)">
                        <small class="text-muted">You can upload multiple secondary images</small>
                        <div id="secondaryPreview" class="mt-2 d-flex flex-wrap gap-2"></div>
                    </div>
                    </div>

                    {{-- Variations --}}
                    <div class="row mb-3">
                      <label class="col-sm-2 col-form-label">Variations</label>
                      <div class="col-sm-10">
                        <div id="variation-wrapper">
                          <!-- First Variation Group -->
                          <div class="variation-group mb-3 border p-3 rounded">
                            <div class="mb-2 d-flex justify-content-between align-items-center">
                              <input type="text" name="variations[0][name]" class="form-control" placeholder="Variation Name (e.g., Size)">
                              <button type="button" class="btn btn-sm btn-danger ms-2 remove-variation">Remove</button>
                            </div>
                            <div class="values-wrapper">
                              <div class="value-row d-flex mb-2">
                                <input type="text" name="variations[0][values][0][value]" class="form-control me-2" placeholder="Value (e.g., Small)">
                                <input type="number" step="0.01" name="variations[0][values][0][price]" class="form-control me-2" placeholder="Price (optional)">
                                <button type="button" class="btn btn-sm btn-outline-danger remove-value">x</button>
                              </div>
                            </div>
                            <button type="button" class="btn btn-sm btn-outline-secondary add-value">+ Add Value</button>
                          </div>
                        </div>
                        <button type="button" class="btn btn-sm btn-primary mt-2" id="add-variation">+ Add Another Variation</button>
                      </div>
                    </div>



                    {{-- Status --}}
                   <div class="row mb-3">
                        <label class="col-sm-2 col-form-label">Active</label>
                        <div class="col-sm-10 d-flex align-items-center">
                            <div class="form-check form-switch">
                            <input 
                                class="form-check-input" 
                                type="checkbox" 
                                name="is_active" 
                                id="is_active" 
                                value="1" 
                                {{ old('is_active', 1) ? 'checked' : '' }}
                            >
                            <label class="form-check-label" for="is_active">Yes, make this product active</label>
                            </div>
                        </div>
                    </div>

                    {{-- Submit --}}
                    <div class="row justify-content-end">
                      <div class="col-sm-10">
                        <button type="submit" class="btn btn-primary">Save Product</button>
                      </div>
                    </div>

                  </form>
                </div>
              </div>
            </div>
          </div>
          <div class="content-backdrop fade"></div>
        </div>
      </div>
    </div>
    <div class="layout-overlay layout-menu-toggle"></div>
  </div>
</div>

{{-- JS to Add More Variations --}}
<script>

 $(document).ready(function() {
    $('.select2').select2({
      placeholder: "-- Select Category --",
      allowClear: true
    });
  });
let variationIndex = 1;

// Add new variation group
document.getElementById('add-variation').addEventListener('click', function () {
  let wrapper = document.getElementById('variation-wrapper');
  let newGroup = document.createElement('div');
  newGroup.classList.add('variation-group', 'mb-3', 'border', 'p-3', 'rounded');
  newGroup.innerHTML = `
    <div class="mb-2 d-flex justify-content-between align-items-center">
      <input type="text" name="variations[${variationIndex}][name]" class="form-control" placeholder="Variation Name (e.g., Color)">
      <button type="button" class="btn btn-sm btn-danger ms-2 remove-variation">Remove</button>
    </div>
    <div class="values-wrapper">
      <div class="value-row d-flex mb-2">
        <input type="text" name="variations[${variationIndex}][values][0][value]" class="form-control me-2" placeholder="Value (e.g., Red)">
        <input type="number" step="0.01" name="variations[${variationIndex}][values][0][price]" class="form-control me-2" placeholder="Price (optional)">
        <button type="button" class="btn btn-sm btn-outline-danger remove-value">x</button>
      </div>
    </div>
    <button type="button" class="btn btn-sm btn-outline-secondary add-value">+ Add Value</button>
  `;
  wrapper.appendChild(newGroup);
  variationIndex++;
});

// Event delegation for dynamically added buttons
document.getElementById('variation-wrapper').addEventListener('click', function (e) {
  if (e.target.classList.contains('add-value')) {
    let group = e.target.closest('.variation-group');
    let valuesWrapper = group.querySelector('.values-wrapper');
    let varNameInput = group.querySelector("input[name^='variations']").name;
    let groupIndex = varNameInput.match(/variations\[(\d+)\]/)[1]; // extract group index
    let valueIndex = valuesWrapper.querySelectorAll('.value-row').length;

    let newValueRow = document.createElement('div');
    newValueRow.classList.add('value-row', 'd-flex', 'mb-2');
    newValueRow.innerHTML = `
      <input type="text" name="variations[${groupIndex}][values][${valueIndex}][value]" class="form-control me-2" placeholder="Value">
      <input type="number" step="0.01" name="variations[${groupIndex}][values][${valueIndex}][price]" class="form-control me-2" placeholder="Price (optional)">
      <button type="button" class="btn btn-sm btn-outline-danger remove-value">x</button>
    `;
    valuesWrapper.appendChild(newValueRow);
  }

  // Remove value row
  if (e.target.classList.contains('remove-value')) {
    e.target.closest('.value-row').remove();
  }

  // Remove entire variation group
  if (e.target.classList.contains('remove-variation')) {
    e.target.closest('.variation-group').remove();
  }
});


  
  function previewPrimary(input) {
    const preview = document.getElementById("primaryPreview");
    preview.innerHTML = ""; // clear old preview
    if (input.files && input.files[0]) {
      const reader = new FileReader();
      reader.onload = function (e) {
        const img = document.createElement("img");
        img.src = e.target.result;
        img.className = "img-thumbnail";
        img.style.maxWidth = "150px";
        img.style.marginTop = "10px";
        preview.appendChild(img);
      };
      reader.readAsDataURL(input.files[0]);
    }
  }

  // Preview for Secondary Images
  function previewSecondary(input) {
    const preview = document.getElementById("secondaryPreview");
    preview.innerHTML = ""; // clear old previews
    if (input.files) {
      Array.from(input.files).forEach(file => {
        const reader = new FileReader();
        reader.onload = function (e) {
          const img = document.createElement("img");
          img.src = e.target.result;
          img.className = "img-thumbnail";
          img.style.maxWidth = "120px";
          img.style.marginTop = "10px";
          preview.appendChild(img);
        };
        reader.readAsDataURL(file);
      });
    }
  }
</script>
@endsection
