<?php
namespace App\Http\Controllers;
use App\Models\Categories;
use App\Models\Products;
use App\Models\Review;
use App\Models\Stores;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Validator;

class ClientController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function getProducts()
    {
        try {
            $products = Products::with([
                    'store:id,name,is_active',
                    'store.deliveryCharges:id,store_id,charges',
                    'category:id,category_name,parent_category_id',
                    'category.parent:id,name',
                    'latestStatus.statuses:id,name,label',
                    'reviews:id,product_id,rating' // 👈 include reviews for ratings
                ])
                ->where('status', 1)
                ->whereHas('store', function ($query) {
                    $query->where('is_active', 1);
                })
                ->get();

            if ($products->isEmpty()) {
                return response()->json([
                    'success' => false,
                    'message' => 'No active products found',
                    'data' => []
                ], 404);
            }

            return response()->json([
                'success' => true,
                'message' => 'Active products retrieved successfully',
                'data' => $products->transform(function ($product) {
                    $averageRating = $product->reviews->avg('rating'); // 👈 calculate average rating

                    return [
                        'id' => $product->id,
                        'name' => $product->name,
                        'description' => $product->description,
                        'price' => $product->price,
                        'image' => url('uploads/products/primary/' . $product->image),
                        'store' => $product->store?->name,
                        'category' => $product->category?->category_name,
                        'parent_category' => $product->category?->parent?->name,
                        'delivery_charges' => $product->store?->deliveryCharges?->charges ?? 0,
                        'is_active' => $product->status,
                        'status' => $product->latestStatus && $product->latestStatus->statuses
                            ? ($product->latestStatus->statuses->label ?? $product->latestStatus->statuses->name)
                            : null,
                        'sale_price' => $product->latestStatus?->sale_price,
                        'average_rating' => $averageRating ? round($averageRating, 1) : 0 // 👈 added rating field
                    ];
                })
            ], 200);

        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Something went wrong while fetching products',
                'error' => $e->getMessage()
            ], 500);
        }
    }


    public function getTrendingProducts()
    {   
        try {
            $products = Products::with([
                    'store:id,name,is_active',
                    'store.deliveryCharges:id,store_id,charges',
                    'category:id,category_name',
                    'latestStatus.statuses:id,name,label',
                    'reviews:id,product_id,rating' // 👈 include ratings
                ])
                ->where('status', 1)
                ->whereHas('store', function ($query) {
                    $query->where('is_active', 1); 
                })
                ->withCount('orderDetails')
                ->orderByDesc('order_details_count')
                ->take(10)
                ->get();

            if ($products->isEmpty()) {
                return response()->json([
                    'success' => false,
                    'message' => 'No trending products found',
                    'data' => []
                ], 404);
            }

            return response()->json([
                'success' => true,
                'message' => 'Top 10 trending products retrieved successfully',
                'data' => $products->transform(function ($product) {
                    $averageRating = $product->reviews->avg('rating'); // 👈 average rating
                    $reviewCount = $product->reviews->count(); // 👈 total reviews (optional)

                    return [
                        'id' => $product->id,
                        'name' => $product->name,
                        'description' => $product->description,
                        'price' => $product->price,
                        'image' => url('uploads/products/primary/' . $product->image),
                        'store' => $product->store?->name,
                        'category' => $product->category?->category_name,
                        'delivery_charges' => $product->store?->deliveryCharges?->charges ?? 0,
                        'is_active' => $product->status,
                        'status' => $product->latestStatus && $product->latestStatus->statuses
                            ? ($product->latestStatus->statuses->label ?? $product->latestStatus->statuses->name)
                            : null,
                        'sale_price' => $product->latestStatus?->sale_price,
                        'sales_count' => $product->order_details_count, // 👈 total times sold
                        'average_rating' => $averageRating ? round($averageRating, 1) : 0, // 👈 added rating
                        'review_count' => $reviewCount // 👈 optional, can remove if not needed
                    ];
                })
            ], 200);

        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Something went wrong while fetching trending products',
                'error' => $e->getMessage()
            ], 500);
        }
    }

   public function getSearchProducts(Request $request)
    {
        try {
            $search = $request->input('search'); // 🔍 search term from query

            $products = Products::with([
                    'store:id,name',
                    'category:id,category_name',
                    'latestStatus.statuses:id,name,label',
                    'reviews:id,product_id,rating' // 👈 include ratings
                ])
                ->where('status', 1) // ✅ only active products
                ->when($search, function ($query, $search) {
                    $query->where(function ($q) use ($search) {
                        $q->where('name', 'LIKE', "%{$search}%")
                        ->orWhere('description', 'LIKE', "%{$search}%")
                        ->orWhereHas('store', function ($storeQuery) use ($search) {
                            $storeQuery->where('name', 'LIKE', "%{$search}%");
                        })
                        ->orWhereHas('category', function ($catQuery) use ($search) {
                            $catQuery->where('category_name', 'LIKE', "%{$search}%");
                        });
                    });
                })
                ->get();

            if ($products->isEmpty()) {
                return response()->json([
                    'success' => false,
                    'message' => 'No products found for the given search',
                    'data' => []
                ], 404);
            }

            return response()->json([
                'success' => true,
                'message' => 'Products retrieved successfully',
                'data' => $products->transform(function ($product) {
                    $averageRating = $product->reviews->avg('rating'); // 👈 average rating
                    $reviewCount = $product->reviews->count(); // 👈 total reviews (optional)

                    return [
                        'id' => $product->id,
                        'name' => $product->name,
                        'description' => $product->description,
                        'price' => $product->price,
                        'image' => url('uploads/products/primary/' . $product->image),
                        'store' => $product->store?->name,
                        'category' => $product->category?->category_name,
                        'is_active' => $product->status,
                        'status' => $product->latestStatus && $product->latestStatus->statuses
                            ? ($product->latestStatus->statuses->label ?? $product->latestStatus->statuses->name)
                            : null,
                        'sale_price' => $product->latestStatus?->sale_price,
                        'average_rating' => $averageRating ? round($averageRating, 1) : 0, // 👈 added rating
                        'review_count' => $reviewCount // 👈 optional, can remove if not needed
                    ];
                })
            ], 200);

        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Something went wrong while fetching products',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    public function getStoreProducts(Request $request)
    {
        try {
            $storeId = $request->input('store_id'); // store_id comes from request

            $products = Products::with([
                    'store:id,name',
                    'category:id,category_name',
                    'latestStatus.statuses:id,name,label'
                ])
                ->where('status', 1) // ✅ only active products
                ->when($storeId, function ($query, $storeId) {
                    $query->where('store_id', $storeId);
                })
                ->get();

            if ($products->isEmpty()) {
                return response()->json([
                    'success' => false,
                    'message' => 'No products found for the given store',
                    'data' => []
                ], 404);
            }

            return response()->json([
                'success' => true,
                'message' => 'Products retrieved successfully',
                'data' => $products->transform(function ($product) {
                    return [
                        'id' => $product->id,
                        'name' => $product->name,
                        'description' => $product->description,
                        'price' => $product->price,
                        'image' => url('uploads/products/primary/' . $product->image),
                        'store' => $product->store?->name,
                        'category' => $product->category?->category_name,
                        'is_active' => $product->status,
                        'status' => $product->latestStatus && $product->latestStatus->statuses
                            ? ($product->latestStatus->statuses->label ?? $product->latestStatus->statuses->name)
                            : null,
                        'sale_price' => $product->latestStatus?->sale_price,
                    ];
                })
            ], 200);

        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Something went wrong while fetching store products',
                'error' => $e->getMessage()
            ], 500);
        }
    }
    /**
     * Show the form for creating a new resource.
     */
  public function getCategories()
    {
        try {

            $categories = Categories::with('parent:id,name')->get();

            if ($categories->isEmpty()) {
                return response()->json([
                    'success' => false,
                    'message' => 'No categories found',
                    'data' => []
                ], 404);
            }

            $grouped = $categories->groupBy(function ($item) {
                return $item->parent?->name ?? 'Uncategorized';
            });

            $data = $grouped->map(function ($items, $parentName) {
                return [
                    'parent_category' => $parentName,
                    'categories' => $items->map(function ($category) {
                        return [
                            'id' => $category->id,
                            'category_name' => $category->category_name,
                        ];
                    })->values()
                ];
            })->values();

            return response()->json([
                'success' => true,
                'message' => 'Categories retrieved successfully',
                'data' => $data
            ], 200);

        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Something went wrong while fetching categories',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    public function getActiveStores()
    {
        try {
            // Fetch stores where status = 1 (active)
            $stores = Stores::where('is_active', 1)->get();

            if ($stores->isEmpty()) {
                return response()->json([
                    'success' => false,
                    'message' => 'No active stores found',
                    'data' => []
                ], 404);
            }

            return response()->json([
                'success' => true,
                'message' => 'Active stores retrieved successfully',
                'data' => $stores
            ], 200);

        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Something went wrong while fetching active stores',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    /**
     * Store a newly created resource in storage.
     */
   public function getSingleProduct($id)
    {
        try {
            $product = Products::with([
                'store:id,name',
                'category:id,category_name',
                'images:id,product_id,path',
                'variations:id,product_id,name,values',
                'reviews' => function ($q) {
                    $q->select('id', 'product_id', 'user_id', 'rating', 'subject', 'review', 'created_at')
                        ->with('user:id,name');
                }
            ])->findOrFail($id);

            // ✅ Prepend full URL for main image
            $product->image = url('uploads/products/primary/' . $product->image);

            // ✅ Prepend full URL for additional images
            foreach ($product->images as $img) {
                $img->path = url('uploads/products/secondary/' . $img->path);
            }

            // ✅ Decode variation values (safe)
            foreach ($product->variations as $variation) {
                if (!empty($variation->values)) {
                    $decoded = json_decode($variation->values, true);
                    $variation->values = is_array($decoded) ? $decoded : [];
                } else {
                    $variation->values = [];
                }
            }

            // ✅ Calculate average rating and review count
            $averageRating = $product->reviews->avg('rating');
            $reviewCount = $product->reviews->count();

            // ✅ Format reviews
            $reviews = $product->reviews->map(function ($review) {
                return [
                    'id'        => $review->id,
                    'user'      => $review->user?->name,
                    'rating'    => $review->rating,
                    'subject'   => $review->subject,
                    'message'   => $review->review,
                    'date'      => $review->created_at->format('Y-m-d H:i'),
                ];
            });

            return response()->json([
                'success' => true,
                'product' => [
                    'id'             => $product->id,
                    'name'           => $product->name,
                    'description'    => $product->description,
                    'price'          => $product->price,
                    'image'          => $product->image,
                    'store'          => $product->store?->name,
                    'category'       => $product->category?->category_name,
                    'images'         => $product->images,
                    'variations'     => $product->variations,
                    'reviews'        => $reviews,
                    'average_rating' => $averageRating ? round($averageRating, 1) : 0, // ⭐ Average rating
                    'review_count'   => $reviewCount, // 💬 Total reviews
                ]
            ], 200);

        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Product not found',
                'error'   => $e->getMessage()
            ], 404);
        }
    }


    public function submitReview(Request $request)
{
        $validator = Validator::make($request->all(), [
            'product_id' => 'required|exists:products,id',
            'user_id'    => 'required|exists:web_users,id', // or users,id if that's your table
            'rating'     => 'required|integer|min:1|max:5',
            'subject'    => 'required|string|max:255',
            'message'    => 'nullable|string',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'errors'  => $validator->errors(),
            ], 422);
        }

        $review = Review::create([
            'product_id' => $request->product_id,
            'user_id'    => $request->user_id,
            'rating'     => $request->rating,
            'subject'    => $request->subject,
            'review'     => $request->message,
        ]);

        return response()->json([
            'success' => true,
            'message' => 'Review submitted successfully!',
            'data'    => $review,
        ], 201);
    }
   
    public function getProductsByStatus()
    {
        try {
            $products = Products::with([
                    'store:id,name,is_active',
                    'store.deliveryCharges:id,store_id,charges',
                    'category:id,category_name,parent_category_id',
                    'category.parent:id,name',
                    'latestStatus.statuses:id,name,label'
                ])
                ->whereHas('latestStatus', function ($query) {
                    $query->where('status_id', 2);
                })
                ->whereHas('store', function ($query) {
                    $query->where('is_active', 1);
                })
                ->get();

            if ($products->isEmpty()) {
                return response()->json([
                    'success' => false,
                    'message' => 'No products found with status ID 2',
                    'data' => []
                ], 404);
            }

            return response()->json([
                'success' => true,
                'message' => 'Products with status ID 2 retrieved successfully',
                'data' => $products->transform(function ($product) {
                    return [
                        'id' => $product->id,
                        'name' => $product->name,
                        'description' => $product->description,
                        'price' => $product->price,
                        'image' => url('uploads/products/primary/' . $product->image),
                        'store' => $product->store?->name,
                        'category' => $product->category?->category_name,
                        'parent_category' => $product->category?->parent?->name,
                        'delivery_charges' => $product->store?->deliveryCharges?->charges ?? 0,
                        'is_active' => $product->status,
                        'status' => $product->latestStatus && $product->latestStatus->statuses
                            ? ($product->latestStatus->statuses->label ?? $product->latestStatus->statuses->name)
                            : null,
                        'sale_price' => $product->latestStatus?->sale_price,
                    ];
                })
            ], 200);

        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Something went wrong while fetching products by status',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    public function getNewArrivals()
    {
        try {
            $oneWeekAgo = Carbon::now()->subWeek();

            $products = Products::with([
                    'store:id,name,is_active',
                    'store.deliveryCharges:id,store_id,charges',
                    'category:id,category_name,parent_category_id',
                    'category.parent:id,name',
                    'latestStatus.statuses:id,name,label'
                ])
                ->where('created_at', '>=', $oneWeekAgo)
                ->whereHas('store', function ($query) {
                    $query->where('is_active', 1);
                })
                ->orderBy('created_at', 'desc') // newest first
                ->limit(5) // limit to 5 latest products
                ->get();

            if ($products->isEmpty()) {
                return response()->json([
                    'success' => false,
                    'message' => 'No new arrivals found in the last week',
                    'data' => []
                ], 404);
            }

            return response()->json([
                'success' => true,
                'message' => 'New arrivals retrieved successfully',
                'data' => $products->transform(function ($product) {
                    return [
                        'id' => $product->id,
                        'name' => $product->name,
                        'description' => $product->description,
                        'price' => $product->price,
                        'image' => url('uploads/products/primary/' . $product->image),
                        'store' => $product->store?->name,
                        'category' => $product->category?->category_name,
                        'parent_category' => $product->category?->parent?->name,
                        'delivery_charges' => $product->store?->deliveryCharges?->charges ?? 0,
                        'is_active' => $product->status,
                        'status' => $product->latestStatus && $product->latestStatus->statuses
                            ? ($product->latestStatus->statuses->label ?? $product->latestStatus->statuses->name)
                            : null,
                        'sale_price' => $product->latestStatus?->sale_price,
                        'created_at' => $product->created_at->toDateString(),
                    ];
                })
            ], 200);

        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Something went wrong while fetching new arrivals',
                'error' => $e->getMessage()
            ], 500);
        }
    }
   

    public function getTopRatedProducts()
    {
        try {

            $products = Products::with([
                    'store:id,name,is_active',
                    'store.deliveryCharges:id,store_id,charges',
                    'category:id,category_name,parent_category_id',
                    'category.parent:id,name',
                    'latestStatus.statuses:id,name,label'
                ])
                ->whereHas('store', function ($query) {
                    $query->where('is_active', 1);
                })
                ->where('status', 1)
                ->withAvg('reviews', 'rating') // Calculate avg rating
                ->orderByDesc('reviews_avg_rating') // Sort by highest rating
                ->limit(5)
                ->get();

            if ($products->isEmpty()) {
                return response()->json([
                    'success' => false,
                    'message' => 'No top-rated products found',
                    'data' => []
                ], 404);
            }

            return response()->json([
                'success' => true,
                'message' => 'Top rated products retrieved successfully',
                'data' => $products->transform(function ($product) {
                    return [
                        'id' => $product->id,
                        'name' => $product->name,
                        'description' => $product->description,
                        'price' => $product->price,
                        'image' => url('uploads/products/primary/' . $product->image),
                        'store' => $product->store?->name,
                        'category' => $product->category?->category_name,
                        'parent_category' => $product->category?->parent?->name,
                        'delivery_charges' => $product->store?->deliveryCharges?->charges ?? 0,
                        'is_active' => $product->status,
                        'status' => $product->latestStatus && $product->latestStatus->statuses
                            ? ($product->latestStatus->statuses->label ?? $product->latestStatus->statuses->name)
                            : null,
                        'sale_price' => $product->latestStatus?->sale_price,
                        'average_rating' => round($product->reviews_avg_rating, 1), // 👈 add average rating
                    ];
                })
            ], 200);

        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Something went wrong while fetching top-rated products',
                'error' => $e->getMessage()
            ], 500);
        }
    }
}
