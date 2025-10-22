<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\Products;
use App\Models\Status;
use App\Models\ProductStatus;
use App\Models\statuses;
use App\Models\Stores;
use Illuminate\Http\Request;

class ProductStatusController extends Controller
{
    /**
     * Display list of product statuses.
     */
    public function __construct()
    {
        $this->middleware('permission:View ProductStatus')->only('index');
        $this->middleware('permission:Edit ProductStatus')->only('edit');
        $this->middleware('permission:Add ProductStatus')->only('create');
        $this->middleware('permission:Delete ProductStatus')->only('destroy');
    }
    public function index()
    {
        $productStatuses = ProductStatus::with(['products', 'statuses', 'users'])->get();

        return view('productStatus.index', compact('productStatuses'));
    }

    /**
     * Show form to assign a new status to a product.
     */
   public function create()
    {
        // Get the store for the current vendor (if any)
        $store = Stores::where('owner_id', auth()->user()->id)->first();

        // Get products based on role
        if (auth()->user()->hasRole('admin')) {
            // Admin sees all products
            $products = Products::select('id', 'name')->get();
        } elseif (auth()->user()->hasRole('Vendor')) {
            // Vendor sees only products of their store
            $products = Products::select('id', 'name')
                ->where('store_id', $store->id ?? 0)
                ->get();
        } else {
            // Other roles: empty
            $products = collect();
        }

        // Filter statuses based on user role
        if (auth()->user()->hasRole('admin')) {
            // Admin sees only 'featured'
            $statuses = statuses::select('id', 'name')
                ->where('name', 'featured')
                ->get();
        } elseif (auth()->user()->hasRole('Vendor')) {
            // Vendor sees only 'sale'
            $statuses = statuses::select('id', 'name')
                ->where('name', 'sale')
                ->get();
        } else {
            // Default: no access or empty result
            $statuses = collect();
        }

        return view('productStatus.create', compact('products', 'statuses'));
    }



    public function store(Request $request)
    {
        try {
            $validated = $request->validate([
                'product_id' => 'required|exists:products,id',
                'status_id' => 'required|exists:statuses,id',
                'sale_price' => 'nullable|numeric|min:0',
            ]);

            $productStatus = new ProductStatus();
            $productStatus->product_id = $validated['product_id'];
            $productStatus->status_id = $validated['status_id'];
            $productStatus->user_id = auth()->id();
            $productStatus->sale_price = $validated['sale_price'] ?? null;
            $productStatus->save();

            return redirect()
                ->route('product-status.index')
                ->with('success', 'Product status assigned successfully');
        } catch (\Exception $e) {
            \Log::error('Status update error', [
                'message' => $e->getMessage(),
                'file' => $e->getFile(),
                'line' => $e->getLine(),
                'trace' => $e->getTraceAsString(),
            ]);

            // For debugging (only in local environment)
            if (app()->environment('local')) {
                dd($e); // dumps full exception on screen
            }

            return back()
                ->withInput()
                ->with('error', 'Something went wrong while updating the status. Please try again.');
        }

    }

    /**
     * Edit an existing product status.
     */
   public function edit($id)
    {
        $productStatus = ProductStatus::findOrFail($id);
        $store = Stores::where('owner_id', auth()->user()->id)->first();
        if (auth()->user()->hasRole('admin')) {
            $products = Products::select('id', 'name')->get();
        } elseif (auth()->user()->hasRole('vendor')) {
            $products = Products::select('id', 'name')
                ->where('store_id', $store->id ?? 0)
                ->get();
        } else {
            $products = collect(); // Empty if unauthorized
        }

        // Filter statuses based on user role
        if (auth()->user()->hasRole('admin')) {
            // Admin sees only 'featured'
            $statuses = statuses::select('id', 'name')
                ->where('name', 'featured')
                ->get();
        } elseif (auth()->user()->hasRole('vendor')) {
            // Vendor sees only 'sale'
            $statuses = statuses::select('id', 'name')
                ->where('name', 'sale')
                ->get();
        } else {
            $statuses = collect(); // Empty if unauthorized
        }

        return view('productStatus.edit', compact('productStatus', 'products', 'statuses'));
    }

    public function update(Request $request, $id)
    {
        try {
            $validated = $request->validate([
                'product_id' => 'required|exists:products,id',
                'status_id' => 'required|exists:statuses,id',
                'sale_price' => 'nullable|numeric|min:0',
            ]);

            $productStatus = ProductStatus::findOrFail($id);
            $productStatus->product_id = $validated['product_id'];
            $productStatus->status_id = $validated['status_id'];
            $productStatus->sale_price = $validated['sale_price'] ?? null;
            $productStatus->save();

            return redirect()
                ->route('product-status.index')
                ->with('success', 'Product status updated successfully');
        } catch (\Exception $e) {
            \Log::error('Product status update error: ' . $e->getMessage());

            return back()
                ->withInput()
                ->with('error', 'Something went wrong while updating the status. Please try again.');
        }
    }

    /**
     * Remove a product status from storage.
     */
    public function destroy($id)
    {
        $productStatus = ProductStatus::find($id);

        if (!$productStatus) {
            return redirect()->route('product-status.index')->with('error', 'Product status not found');
        }

        $productStatus->delete();

        return redirect()->route('product-status.index')->with('success', 'Product status deleted successfully');
    }

    public function bulkDelete(Request $request)
    {
        $ids = $request->input('ids'); // array of product_status IDs
        if (!empty($ids)) {
            ProductStatus::whereIn('id', $ids)->delete();
        }

        return response()->json(['success' => 'Product statuses deleted successfully!']);
    }

    public function getProductStatuses(Request $request)
    {
        if ($request->ajax()) {
            $user = auth()->user();

            // Base query with relationships
            $statuses = ProductStatus::with([
                'products:id,name,store_id',
                'statuses:id,name,label',
                'users:id,name'
            ])
            ->select(['id', 'product_id', 'status_id', 'user_id', 'sale_price', 'created_at']);

            // 🔹 Role-based filtering
            if ($user->hasRole('Vendor')) {
                $store = $user->store; // vendor's store relationship

                if ($store) {
                    $statuses->whereHas('products', function ($query) use ($store) {
                        $query->where('store_id', $store->id);
                    });
                } else {
                    // Vendor has no store — return empty
                    $statuses->whereRaw('1 = 0');
                }
            }

            // 🔹 Status filter depending on role
            $statuses->whereHas('statuses', function ($query) use ($user) {
                if ($user->hasRole('admin')) {
                    $query->where('name', 'featured');
                } elseif ($user->hasRole('Vendor')) {
                    $query->where('name', 'sale');
                }
            });

            return datatables()->of($statuses)
                ->addIndexColumn()
                ->addColumn('product', function ($row) {
                    return $row->products ? $row->products->name : '-';
                })
                ->addColumn('status', function ($row) {
                    return $row->statuses ? ($row->statuses->label ?? $row->statuses->name) : '-';
                })
                ->addColumn('user', function ($row) {
                    return $row->users ? $row->users->name : 'System';
                })
                ->addColumn('sale_price', function ($row) {
                    return $row->sale_price ? number_format($row->sale_price, 2) : '-';
                })
                ->addColumn('action', function ($row) {
                    return '<div class="dropdown">
                        <button type="button" class="btn p-0 dropdown-toggle hide-arrow" data-bs-toggle="dropdown">
                            <i class="bx bx-dots-vertical-rounded"></i>
                        </button>
                        <div class="dropdown-menu">
                            <a class="dropdown-item" href="' . route('product-status.edit', $row->id) . '">
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


}
