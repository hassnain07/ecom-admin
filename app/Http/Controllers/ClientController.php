<?php

namespace App\Http\Controllers;

use App\Models\Categories;
use App\Models\Products;
use Illuminate\Http\Request;

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
            'productStatus.statuses:id,name,label' // eager load status through productStatus
        ])->get();

        if ($products->isEmpty()) {
            return response()->json([
                'success' => false,
                'message' => 'No products found',
                'data'    => []
            ], 404);
        }

        return response()->json([
            'success' => true,
            'message' => 'Products retrieved successfully',
            'data'    => $products->transform(function ($product) {
                return [
                    'id'          => $product->id,
                    'name'        => $product->name,
                    'description' => $product->description,
                    'price'       => $product->price,
                    'image'       => url('uploads/products/primary/' . $product->image),
                    'store'       => $product->store ? $product->store->name : null,
                    'category'    => $product->category ? $product->category->category_name : null,
                    'status'      => $product->productStatus && $product->productStatus->statuses
                        ? ($product->productStatus->statuses->label ?? $product->productStatus->statuses->name)
                        : null,
                    'sale_price'  => $product->productStatus ? $product->productStatus->sale_price : null,
                ];
            })
        ], 200);

    } catch (\Exception $e) {
        return response()->json([
            'success' => false,
            'message' => 'Something went wrong while fetching products',
            'error'   => $e->getMessage()
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
                    'data'    => []
                ], 404);
            }

            return response()->json([
                'success' => true,
                'message' => 'Categories retrieved successfully',
                'data'    => $categories
            ], 200);

        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Something went wrong while fetching categories',
                'error'   => $e->getMessage()
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
