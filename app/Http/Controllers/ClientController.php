<?php

namespace App\Http\Controllers;

use App\Models\Categories;
use App\Models\Products;
use App\Models\Review;
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
                'store:id,name',
                'category:id,category_name',
                'latestStatus.statuses:id,name,label'
            ])
                ->where('status', 1) // ✅ only active products
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
                    return [
                        'id' => $product->id,
                        'name' => $product->name,
                        'description' => $product->description,
                        'price' => $product->price,
                        'image' => url('uploads/products/primary/' . $product->image),
                        'store' => $product->store?->name,
                        'category' => $product->category?->category_name,

                        'is_active' => $product->status,  // products table flag
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
                'message' => 'Something went wrong while fetching products',
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
            $categories = Categories::all();

            if ($categories->isEmpty()) {
                return response()->json([
                    'success' => false,
                    'message' => 'No categories found',
                    'data' => []
                ], 404);
            }

            return response()->json([
                'success' => true,
                'message' => 'Categories retrieved successfully',
                'data' => $categories
            ], 200);

        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Something went wrong while fetching categories',
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
                'variations:id,product_id,name,values'
            ])->findOrFail($id);

            // Prepend full URL for main image
            $product->image = url('uploads/products/primary/' . $product->image);

            // Prepend full URL for additional images
            foreach ($product->images as $img) {
                $img->path = url('uploads/products/secondary/' . $img->path);
            }

            return response()->json([
                'success' => true,
                'product' => $product
            ], 200);

        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Product not found',
                'error' => $e->getMessage()
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
