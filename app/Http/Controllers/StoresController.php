<?php

namespace App\Http\Controllers;

use App\Models\Blogs;
use App\Models\Categories;
use App\Models\Stores;
use Illuminate\Http\Request;

class StoresController extends Controller
{
        public function index()
    {
        return view('stores.index');
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('stores.create');
    }

    /**
     * Store a newly created resource in storage.
     */
  public function store(Request $request)
    {
        try {
            $validated = $request->validate([
                'name'             => 'required|string|min:3|max:100|unique:stores,name',
                'description'      => 'nullable|string|max:500',
                'logo'             => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
                'banner'           => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:4096',
                'contact_phone'    => 'nullable|string|max:20',
                'contact_address'  => 'nullable|string|max:255',
                'contact_postal_code' => 'nullable|string|max:20',
                'shipping_policy'  => 'nullable|string',
                'return_policy'    => 'nullable|string',
                'privacy_policy'   => 'nullable|string',
                'is_active'        => 'nullable|boolean',
            ], [
                'name.required' => 'The store name is required.',
                'name.string'   => 'The store name must be valid text.',
                'name.max'      => 'The store name cannot exceed 100 characters.',
                'name.unique'   => 'This store name already exists.',
                'logo.image'    => 'The logo must be an image file.',
                'banner.image'  => 'The banner must be an image file.',
            ]);

            // ✅ Handle file uploads
            $logoPath = null;
            $bannerPath = null;

           if ($request->hasFile('logo') && $request->file('logo')->isValid()) {
                $file = $request->file('logo');
                $fileName = time() . '.' . $file->getClientOriginalExtension();
                $file->move(public_path('uploads/logos/'), $fileName);
    
                $logoPath= $fileName;
            }
           if ($request->hasFile('banner') && $request->file('banner')->isValid()) {
                $file = $request->file('banner');
                $fileName = time() . '.' . $file->getClientOriginalExtension();
                $file->move(public_path('uploads/banners/'), $fileName);
    
                $bannerPath= $fileName;
            }

            $store = new Stores();
            $store->name              = $validated['name'];
            $store->description       = $validated['description'] ?? null;
            $store->logo              = $logoPath;
            $store->banner            = $bannerPath;

            // Attach logged-in user as owner
            $store->owner_id          = auth()->id();

            $store->contact_phone     = $validated['contact_phone'] ?? null;
            $store->contact_address   = $validated['contact_address'] ?? null;
            $store->contact_postal_code = $validated['contact_postal_code'] ?? null;

            $store->shipping_policy   = $validated['shipping_policy'] ?? null;
            $store->return_policy     = $validated['return_policy'] ?? null;
            $store->privacy_policy    = $validated['privacy_policy'] ?? null;

            $store->is_active         = $request->has('is_active') ? 1 : 0;

            $store->save();

            return redirect()
                ->route('stores.index')
                ->with('success', 'Store added successfully');
        } catch (\Exception $e) {
            \Log::error('Store save error: ' . $e->getMessage());

            return back()
                ->withInput()
                ->with('error', 'Something went wrong while saving the store. Please try again.');
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
        $store = Stores::findOrFail($id);
        return view('stores.edit',compact('store'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        try {
            $validated = $request->validate([
                'name'             => 'required|string|min:3|max:100|unique:stores,name,' . $id,
                'description'      => 'nullable|string|max:500',
                'logo'             => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
                'banner'           => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:4096',
                'contact_phone'    => 'nullable|string|max:20',
                'contact_address'  => 'nullable|string|max:255',
                'contact_postal_code' => 'nullable|string|max:20',
                'shipping_policy'  => 'nullable|string',
                'return_policy'    => 'nullable|string',
                'privacy_policy'   => 'nullable|string',
                'is_active'        => 'nullable|boolean',
            ], [
                'name.required' => 'The store name is required.',
                'name.string'   => 'The store name must be valid text.',
                'name.max'      => 'The store name cannot exceed 100 characters.',
                'name.unique'   => 'This store name already exists.',
                'logo.image'    => 'The logo must be an image file.',
                'banner.image'  => 'The banner must be an image file.',
            ]);

            $store = Stores::findOrFail($id);

            if ($request->hasFile('logo') && $request->file('logo')->isValid()) {
                $file = $request->file('logo');
                $fileName = time() . '_logo.' . $file->getClientOriginalExtension();
                $file->move(public_path('uploads/logos/'), $fileName);

                // delete old logo if exists
                if ($store->logo && file_exists(public_path('uploads/logos/' . $store->logo))) {
                    unlink(public_path('uploads/logos/' . $store->logo));
                }

                $store->logo = $fileName;
            }

            if ($request->hasFile('banner') && $request->file('banner')->isValid()) {
                $file = $request->file('banner');
                $fileName = time() . '_banner.' . $file->getClientOriginalExtension();
                $file->move(public_path('uploads/banners/'), $fileName);

                // delete old banner if exists
                if ($store->banner && file_exists(public_path('uploads/banners/' . $store->banner))) {
                    unlink(public_path('uploads/banners/' . $store->banner));
                }

                $store->banner = $fileName;
            }

            $store->name              = $validated['name'];
            $store->description       = $validated['description'] ?? $store->description;
            $store->contact_phone     = $validated['contact_phone'] ?? $store->contact_phone;
            $store->contact_address   = $validated['contact_address'] ?? $store->contact_address;
            $store->contact_postal_code = $validated['contact_postal_code'] ?? $store->contact_postal_code;

            $store->shipping_policy   = $validated['shipping_policy'] ?? $store->shipping_policy;
            $store->return_policy     = $validated['return_policy'] ?? $store->return_policy;
            $store->privacy_policy    = $validated['privacy_policy'] ?? $store->privacy_policy;

            $store->is_active         = $request->has('is_active') ? 1 : 0;

            $store->save();

            return redirect()
                ->route('stores.index')
                ->with('success', 'Store updated successfully');
        } catch (\Exception $e) {
            \Log::error('Store update error: ' . $e->getMessage());

            return back()
                ->withInput()
                ->with('error', 'Something went wrong while updating the store. Please try again.');
        }
    }



    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $store = Stores::find($id);
        if ($store == null) {

            return redirect()->route('stores.index')->with('error','Store Not Found');
            
        }else {
            $store->delete();
            return redirect()->route('stores.index')->with('success','Store deleted successfully');

        }
    }

    public function getStores(Request $request)
    {
        if ($request->ajax()) {
            $stores = Stores::select(['id','name','owner_id','is_active']);
    
            return datatables()->of($stores)
                ->addIndexColumn()
                ->addColumn('action', function ($row) {
                    return '<div class="dropdown">
                        <button type="button" class="btn p-0 dropdown-toggle hide-arrow" data-bs-toggle="dropdown">
                            <i class="bx bx-dots-vertical-rounded"></i>
                        </button>
                        <div class="dropdown-menu">
                            <a class="dropdown-item" href="' . route('stores.edit', $row->id) . '">
                                <i class="bx bx-edit-alt me-1"></i> Edit
                            </a>
                            <button type="button" class="dropdown-item delete-button" data-id="' . $row->id . '" data-bs-toggle="modal" data-bs-target="#deleteModal">
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
            Stores::whereIn('id', $ids)->delete();  // Delete users with the selected IDs
        }
        
        return response()->json(['success' => 'Stores deleted successfully!']);
    }
}
