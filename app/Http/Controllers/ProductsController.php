<?php

namespace App\Http\Controllers;

use App\Models\Products;
use App\Http\Requests\StoreproductsRequest;
use App\Http\Requests\UpdateproductsRequest;
use App\Http\Resources\ProductsResource;
use App\Services\ProductServices;
use Illuminate\Support\Facades\Cache;

class ProductsController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Products $product)
    {
        $value = Cache::rememberForever('products', function () {
            return ProductsResource::collection(Products::cursorPaginate(10));
        });
        return $value;
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreproductsRequest $request, ProductServices $productServices, Products $product)
    {
        $productCreated = $productServices->store($request, $product);
        return new ProductsResource($productCreated);
    }

    /**
     * Display the specified resource.
     */
    public function show(Products $product)
    {
        return new ProductsResource($product);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateproductsRequest $request, products $products)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(products $products)
    {
        //
    }
}
