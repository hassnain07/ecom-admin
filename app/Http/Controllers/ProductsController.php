<?php

namespace App\Http\Controllers;

use App\Models\Blogs;
use App\Models\Categories;
use App\Models\ProductImages;
use App\Models\Products;
use App\Models\Stores;
use Illuminate\Http\Request;

class ProductsController extends Controller
{
        public function index()
    {
        
        return view('products.index',);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $categories = Categories::all();
        $stores = Stores::all();
        return view('products.create',compact('categories','stores'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        try {
            $validated = $request->validate([
                'name'          => 'required|string|min:3|max:255',
                'description'   => 'required|string',
                'price'         => 'required|numeric|min:0',
                'category_id'   => 'required|exists:categories,id',
                'primary_image' => 'required|image|mimes:jpeg,png,jpg,gif,svg|max:4096',
                'secondary_images.*' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:4096',
                'variations'    => 'nullable|array',
            ], [
                'name.required' => 'The product name is required.',
                'price.required'=> 'Product must have a base price.',
                'category_id.required' => 'Please select a category.',
                'primary_image.required' => 'A primary image is required.',
            ]);

            $primaryImagePath = null;
            if ($request->hasFile('primary_image') && $request->file('primary_image')->isValid()) {
                $file = $request->file('primary_image');
                $fileName = time() . '_primary.' . $file->getClientOriginalExtension();
                $file->move(public_path('uploads/products/primary'), $fileName);

                $primaryImagePath = $fileName;
            }

            $product = new Products();
            $product->name        = $validated['name'];
            $product->description = $validated['description'] ?? null;
            $product->price       = $validated['price'];
            $product->category_id = $validated['category_id'];
            $product->image       = $primaryImagePath;
            $product->status      = $request->has('is_active') ? 1 : 0;

            $store = Stores::where('owner_id', auth()->id())->first();
            if ($store) {
                $product->store_id = $store->id;
            } else {
                throw new \Exception("No store found for this user.");
            }

            $product->save();

            if ($request->hasFile('secondary_images')) {
                foreach ($request->file('secondary_images') as $file) {
                    if ($file->isValid()) {
                        $fileName = time() . '_' . uniqid() . '.' . $file->getClientOriginalExtension();
                        $file->move(public_path('uploads/products/secondary/'), $fileName);

                        $product->images()->create([
                            'path' => $fileName,
                        ]);
                    }
                }
            }

            if ($request->has('variations')) {
                foreach ($request->variations as $variation) {
                    if (!empty($variation['name']) && !empty($variation['values'])) {
                        $values = array_values($variation['values']); // reindex

                        $product->variations()->create([
                            'name'   => $variation['name'],
                            'values' => json_encode($values, JSON_UNESCAPED_UNICODE),
                        ]);
                    }
                }
            }

            return redirect()
                ->route('products.index')
                ->with('success', 'Product added successfully');

        } catch (\Throwable $e) {
            // Log full error
            \Log::error('Product save error: ' . $e->getMessage(), [
                'file' => $e->getFile(),
                'line' => $e->getLine(),
                'trace' => $e->getTraceAsString(),
            ]);

            // Show meaningful message in UI (for dev, not production!)
            return back()
                ->withInput()
                ->with('error', 'Error: ' . $e->getMessage() . ' (line ' . $e->getLine() . ')');
        }
    }




    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $product = Products::with(['images', 'variations'])->findOrFail($id);
        $categories = Categories::all();
        return view('products.edit',compact('product','categories'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
{
    try {
        $product = Products::with(['images', 'variations'])->findOrFail($id);

        // ✅ Validation
        $validated = $request->validate([
            'name'          => 'required|string|min:3|max:255' . $product->id,
            'description'   => 'required|string',
            'price'         => 'required|numeric|min:0',
            'category_id'   => 'required|exists:categories,id',
            'primary_image' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:4096',
            'secondary_images.*' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:4096',
            'variations'    => 'nullable|array',
        ]);

        // ✅ Update primary image if new one uploaded
        if ($request->hasFile('primary_image') && $request->file('primary_image')->isValid()) {
            // delete old if exists
            if ($product->image && file_exists(public_path('uploads/products/primary/' . $product->image))) {
                unlink(public_path('uploads/products/primary/' . $product->image));
            }

            $file = $request->file('primary_image');
            $fileName = time() . '_primary.' . $file->getClientOriginalExtension();
            $file->move(public_path('uploads/products/primary'), $fileName);
            $product->image = $fileName;
        }

            $product->name        = $validated['name'];
            $product->description = $validated['description'];
            $product->price       = $validated['price'];
            $product->category_id = $validated['category_id'];
            $product->status      = $request->has('is_active') ? 1 : 0;

            $store = Stores::where('owner_id', auth()->id())->first();
            if ($store) {
                $product->store_id = $store->id;
            } else {
                throw new \Exception("No store found for this user.");
            }

            $product->save();

            // ✅ Handle secondary images (delete old and re-add if new provided)
            if ($request->hasFile('secondary_images')) {
                // delete old files
                foreach ($product->images as $img) {
                    $oldPath = public_path('uploads/products/secondary/' . $img->path);
                    if (file_exists($oldPath)) {
                        unlink($oldPath);
                    }
                    $img->delete();
                }

                // upload new files
                foreach ($request->file('secondary_images') as $file) {
                    if ($file->isValid()) {
                        $fileName = time() . '_' . uniqid() . '.' . $file->getClientOriginalExtension();
                        $file->move(public_path('uploads/products/secondary/'), $fileName);

                        $product->images()->create([
                            'path' => $fileName,
                        ]);
                    }
                }
            }

            // ✅ Handle variations (delete old + add new)
            if ($request->has('variations')) {
                // clear existing
                $product->variations()->delete();

                foreach ($request->variations as $variation) {
                    if (!empty($variation['name']) && !empty($variation['values'])) {
                        $values = array_values($variation['values']); // reindex
                        $product->variations()->create([
                            'name'   => $variation['name'],
                            'values' => json_encode($values, JSON_UNESCAPED_UNICODE),
                        ]);
                    }
                }
            }

            return redirect()
                ->route('products.index')
                ->with('success', 'Product updated successfully');

        } catch (\Throwable $e) {
            \Log::error('Product update error: ' . $e->getMessage(), [
                'file' => $e->getFile(),
                'line' => $e->getLine(),
                'trace' => $e->getTraceAsString(),
            ]);

            return back()
                ->withInput()
                ->with('error', 'Error: ' . $e->getMessage() . ' (line ' . $e->getLine() . ')');
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $products = Products::find($id);
        if ($products == null) {

            return redirect()->route('products.index')->with('error','Product Not Found');
            
        }else {
            $products->delete();
            return redirect()->route('products.index')->with('success','Product deleted successfully');

        }
    }

    public function getProducts(Request $request)
    {
        if ($request->ajax()) {
            $products = Products::with('store:id,name') // eager load store
                ->select(['id', 'name', 'store_id', 'price', 'status'])
                ->whereHas('store', function ($query) {
                    $query->where('owner_id', auth()->id()); // only show products of the logged-in user's store(s)
                });

            return datatables()->of($products)
                ->addIndexColumn()
                ->addColumn('store_name', function ($row) {
                    return $row->store ? $row->store->name : 'N/A';
                })
                ->addColumn('action', function ($row) {
                    return '<div class="dropdown">
                        <button type="button" class="btn p-0 dropdown-toggle hide-arrow" data-bs-toggle="dropdown">
                            <i class="bx bx-dots-vertical-rounded"></i>
                        </button>
                        <div class="dropdown-menu">
                            <a class="dropdown-item" href="' . route('products.edit', $row->id) . '">
                                <i class="bx bx-edit-alt me-1"></i> Edit
                            </a>
                            <button type="button" class="dropdown-item delete-button" 
                                data-id="' . $row->id . '" 
                                data-bs-toggle="modal" data-bs-target="#deleteModal">
                                <i class="bx bx-trash me-1"></i> Delete
                            </button>
                        </div>
                    </div>';
                })
                ->rawColumns(['action'])
                ->make(true);
        }
    }
    


    public function bulkDelete(Request $request)
    {
        $ids = $request->input('ids'); // Array of selected user IDs
        if (!empty($ids)) {
            Products::whereIn('id', $ids)->delete();  // Delete users with the selected IDs
        }
        
        return response()->json(['success' => 'Products deleted successfully!']);
    }
}
