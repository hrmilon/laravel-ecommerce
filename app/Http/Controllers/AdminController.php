<?php

namespace App\Http\Controllers;

use App\Http\Resources\ProductsResource;
use App\Models\Admin;
use App\Models\Products;
use App\Services\ProductServices;
use Illuminate\Container\Attributes\DB;
use Illuminate\Http\Request;

class AdminController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Products $products, ProductServices $productService)
    {
        $allProducts = $productService->getAllProductsAdmin($products);
        return $allProducts;
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
    public function show(Admin $admin)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Admin $admin)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Admin $admin)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Admin $admin)
    {
        //
    }

    public function pendingProducts(Products $products)
    {
        $inPending = Products::where('approved', '=', "0")->get();
        //get all the pending products to approve
        $all = $inPending->count();
        $pluck = $products->pluck("name", "price");

        //show the list
        return ProductsResource::collection($inPending);
    }

    public function approval($id, Products $products)
    {
        try {
            $product = $products->find($id);
            $product->approved = 1;
            $product->save();

            return new ProductsResource($product);
        } catch (\Throwable $th) {
            return $th;
        }
    }
}
