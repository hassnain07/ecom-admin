<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class dashboardController extends Controller
{
    /**
     * Display a listing of the resource.
     */
public function index()
{
    $user = auth()->user();
    $isAdmin = $user->role === 'admin';

    if ($isAdmin) {
        // Admin dashboard (all data)
        $totalStores    = \App\Models\Stores::count();
        $totalProducts  = \App\Models\Products::count();
        $totalOrders    = \App\Models\Orders::count();
        $totalUsers     = \App\Models\WebUsers::count();
        $totalRevenue   = \App\Models\Orders::sum('total');
        $averageRating  = \App\Models\Review::avg('rating');

        $salesData = \App\Models\Orders::selectRaw('MONTH(created_at) as month, SUM(total) as total')
            ->groupBy('month')
            ->orderBy('month')
            ->get();
    } else {
        // Store owner dashboard (filter by their store IDs)
        $storeIds = \App\Models\Stores::where('owner_id', $user->id)->pluck('id');

        $totalStores    = $storeIds->count();
        $totalProducts  = \App\Models\Products::whereIn('store_id', $storeIds)->count();

        $totalOrders    = \App\Models\Orders::whereHas('Details.product', function ($q) use ($storeIds) {
                                $q->whereIn('store_id', $storeIds);
                            })->count();

        // Distinct customers who placed orders containing this store's products
        $totalUsers = \App\Models\Orders::join('order_details', 'orders.id', '=', 'order_details.order_id')
        ->join('products', 'order_details.product_id', '=', 'products.id')
        ->whereIn('products.store_id', $storeIds)
        ->distinct('orders.email')
        ->count('orders.email');


        $totalRevenue   = \App\Models\Orders::whereHas('Details.product', function ($q) use ($storeIds) {
                                $q->whereIn('store_id', $storeIds);
                            })->sum('total');

        $averageRating  = \App\Models\Review::whereHas('product', function ($q) use ($storeIds) {
                                $q->whereIn('store_id', $storeIds);
                            })->avg('rating');

        $salesData = \App\Models\Orders::selectRaw('MONTH(orders.created_at) as month, SUM(orders.total) as total')
            ->whereHas('Details.product', function ($q) use ($storeIds) {
                $q->whereIn('store_id', $storeIds);
            })
            ->groupBy('month')
            ->orderBy('month')
            ->get();
    }

    $salesMonths = $salesData->pluck('month');
    $salesTotals = $salesData->pluck('total');

    // Orders by status
    if ($isAdmin) {
        $ordersByStatus = \App\Models\Orders::selectRaw('status, COUNT(*) as count')
            ->groupBy('status')
            ->pluck('count','status')
            ->toArray();
    } else {
        $ordersByStatus = \App\Models\Orders::whereHas('Details.product', function ($q) use ($storeIds) {
                                $q->whereIn('store_id', $storeIds);
                            })
                            ->selectRaw('status, COUNT(*) as count')
                            ->groupBy('status')
                            ->pluck('count','status')
                            ->toArray();
    }

    // Recent orders
    $recentOrders = $isAdmin
        ? \App\Models\Orders::latest()->take(5)->get()
        : \App\Models\Orders::whereHas('Details.product', function ($q) use ($storeIds) {
                $q->whereIn('store_id', $storeIds);
            })->latest()->take(5)->get();

    // Top rated products
    $topRatedProducts = $isAdmin
        ? \App\Models\Products::withAvg('reviews', 'rating')
            ->orderByDesc('reviews_avg_rating')
            ->take(5)->get()
        : \App\Models\Products::whereIn('store_id', $storeIds)
            ->withAvg('reviews', 'rating')
            ->orderByDesc('reviews_avg_rating')
            ->take(5)->get();

    return view('dashboard', compact(
        'totalStores', 'totalProducts', 'totalOrders', 'totalUsers',
        'totalRevenue', 'averageRating', 'salesMonths', 'salesTotals',
        'ordersByStatus', 'recentOrders', 'topRatedProducts', 'isAdmin'
    ));
}




    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
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
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
