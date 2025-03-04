<?php

namespace App\Http\Controllers;

use App\Models\Products;
use App\Http\Requests\StoreproductsRequest;
use App\Http\Requests\UpdateproductsRequest;
use App\Http\Resources\ProductsResource;
use App\Models\Admin;
use App\Models\User;
use App\Policies\ProductsPolicy;
use App\Services\ProductServices;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Support\Facades\Cache;

class ProductsController extends Controller
{
    use AuthorizesRequests;
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
    public function store(StoreProductsRequest $request, ProductServices $productServices, Products $product)
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
    public function update(UpdateProductsRequest $request, Products $product, ProductServices $service)
    {
        if ($this->authorize('update', $product)) {;
            $updated = $service->update($request, $product);
            return new ProductsResource($product);
        }

        return "error";
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(products $product)
    {
        if ($this->authorize('update', $product)) {;
            $product->delete();
            return response()->json([
                "Deleted Successfully"
            ]);
        }

        return response()->json(["Error occured during Deletion"]);
    }
}
