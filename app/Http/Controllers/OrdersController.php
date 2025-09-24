<?php

namespace App\Http\Controllers;
use App\Models\order_details;
use App\Models\Orders;
use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;

use Illuminate\Support\Facades\DB;
 
class OrdersController extends Controller
{

    public function __construct()
    {
        $this->middleware('permission:Manage Orders')->only('index');
    }
    public function index(){

        return view("orders.index");

    }
    public function placeOrder(Request $request)
    {
        $validated = $request->validate([
            'customer_name'    => 'required|string|max:255',
            'email'            => 'required|email',
            'phone'            => 'required|string|max:20',
            'shipping_address' => 'required|string',
            'city'             => 'required|string|max:100',
            'postal_code'      => 'required|string|max:20',
            'items'            => 'required|array',
            'items.*.product_id' => 'required|integer|exists:products,id',
            'items.*.variation'  => 'nullable|string|max:255',
            'items.*.quantity'   => 'required|integer|min:1',
            'items.*.price'      => 'required|numeric|min:0',
        ]);

        DB::beginTransaction();

        try {
            // calculate total
            $total = collect($validated['items'])->sum(function ($item) {
                return $item['quantity'] * $item['price'];
            });

            // create order
            $order = Orders::create([
                'customer_name'    => $validated['customer_name'],
                'email'            => $validated['email'],
                'phone'            => $validated['phone'],
                'shipping_address' => $validated['shipping_address'],
                'city'             => $validated['city'],
                'postal_code'      => $validated['postal_code'],
                'total'            => $total,
                'status'           => 'pending',
            ]);

            // insert details
            foreach ($validated['items'] as $item) {
                order_details::create([
                    'order_id'   => $order->id,
                    'product_id' => $item['product_id'],
                    'variation'  => $item['variation'] ?? null,
                    'quantity'   => $item['quantity'],
                    'price'      => $item['price'],
                ]);
            }

            DB::commit();

            return response()->json([
                'success' => true,
                'message' => 'Order placed successfully!',
                'order_id' => $order->id,
            ]);

        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json([
                'success' => false,
                'message' => 'Order placement failed',
                'error'   => $e->getMessage(),
            ], 500);
        }
    }

   public function getOrders(Request $request)
    {
        if ($request->ajax()) {
            $orders = Orders::select([
                'orders.id',
                'orders.customer_name',
                'orders.email',
                'orders.phone',
                DB::raw('SUM(order_details.quantity * order_details.price) as total'),
                'orders.status',
                'stores.name as store_name'
            ])
            ->join('order_details', 'orders.id', '=', 'order_details.order_id')
            ->join('products', 'order_details.product_id', '=', 'products.id')
            ->join('stores', 'products.store_id', '=', 'stores.id')
            ->where('stores.owner_id', auth()->id()) // ✅ only logged-in store owner’s products
            ->groupBy(
                'orders.id',
                'orders.customer_name',
                'orders.email',
                'orders.phone',
                'orders.status',
                'stores.name'
            );

            return DataTables::of($orders)
                ->addIndexColumn()
                ->addColumn('action', function ($row) {
                    return '
                        <div class="dropdown">
                            <button type="button" class="btn p-0 dropdown-toggle hide-arrow" data-bs-toggle="dropdown">
                                <i class="bx bx-dots-vertical-rounded"></i>
                            </button>
                            <div class="dropdown-menu">
                                <a class="dropdown-item view-order" href="javascript:void(0)" data-id="' . $row->id . '">
                                    <i class="bx bx-show-alt me-1"></i> View
                                </a>
                                <a class="dropdown-item change-status" href="javascript:void(0)" data-id="' . $row->id . '" data-status="processing">
                                    <i class="bx bx-package me-1"></i> Mark as Processing
                                </a>
                                <a class="dropdown-item change-status" href="javascript:void(0)" data-id="' . $row->id . '" data-status="completed">
                                    <i class="bx bx-check-circle me-1"></i> Mark as Completed
                                </a>
                                <a class="dropdown-item change-status" href="javascript:void(0)" data-id="' . $row->id . '" data-status="cancel">
                                    <i class="bx bx-x-circle me-1"></i> Mark as Cancel
                                </a>
                            </div>
                        </div>';
                })
                ->rawColumns(['action'])
                ->make(true);
        }
    }


    public function destroy($id){

    }
    public function show($id)
    {
        $order = Orders::with([
                'Details' => function ($q) {
                    $q->whereHas('product.store', function ($query) {
                        $query->where('owner_id', auth()->id());
                    });
                },
                'Details.product.store'
            ])
            ->where('id', $id)
            ->firstOrFail();

        // Sum only the details that belong to this store
        $storeTotal = $order->Details->sum(function ($item) {
            return ($item->quantity ?? 0) * ($item->price ?? 0);
        });

        // Optional: store name (if you want to show it)
        $storeName = optional($order->Details->first()->product->store)->name;

        return view('orders.partials.details', compact('order', 'storeTotal', 'storeName'));
    }
    public function updateStatus(Request $request, $id)
    {
        $request->validate([
            'status' => 'required|string|max:50',
        ]);

        $order = Orders::findOrFail($id);
        $order->status = $request->status;
        $order->save();

        return response()->json([
            'success' => true,
            'message' => 'Order status updated successfully!',
            'status'  => $order->status
        ]);
    }
}
