<?php

namespace App\Http\Controllers;

use App\Models\Products;
use App\Http\Requests\StoreproductsRequest;
use App\Http\Requests\UpdateproductsRequest;
use App\Http\Resources\ProductsResource;
use App\Services\ProductServices;
use App\Traits\ApiResponses;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Support\Facades\Cache;

class ProductsController extends Controller
{
    use AuthorizesRequests;
    use ApiResponses;
    /**
     * Display a listing of the resource.
     */
    public function index(Products $product)
    {
        // return only approved products
        
        $approved = Products::where('approved', '=', "1");
        if (!$approved->exists()) {
            return response()->json([
                "message" => "No more products"
            ]);
        }

        return ProductsResource::collection(Products::where('approved', '=', "1")->cursorPaginate(10));
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

        return $this->error([
            "message" => "Error Occured During Updating"
        ]);
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

        return $this->error([
            "message" => "Error Occured During Deletion"
        ]);
    }
}
