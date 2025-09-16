<?php

namespace App\Http\Controllers;

use App\Models\Review;
use App\Models\Stores;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ReviewController extends Controller
{
    public function index()
    {
        return view('reviews.index');
    }

public function getReviews(Request $request)
{
    if ($request->ajax()) {
        $reviews = Review::with(['product', 'user'])
            ->select(['id','product_id','user_id','rating','review','subject','created_at']);

        return datatables()->of($reviews)
            ->addIndexColumn()
            ->addColumn('product_name', function ($row) {
                return $row->product ? $row->product->name : '-';
            })
            ->addColumn('user_name', function ($row) {
                return $row->user ? $row->user->name : '-';
            })
            ->editColumn('created_at', function ($row) {
                return $row->created_at ? $row->created_at->format('M d, Y h:i A') : '-';
            })
            
            ->rawColumns(['action'])
            ->make(true);
    }
}



}
