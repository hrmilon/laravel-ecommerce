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
     * Public.
     */
    public function index(Products $products, ProductServices $service)
    {
        $results = $service->viewProductsPublic($products);
        return $results;
    }

    public function show($id, Products $product, ProductServices $ProductService)
    {
        $results = $ProductService->show($product, $id);
        return $results;
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreProductsRequest $request, ProductServices $productServices, Products $product)
    {
        //TODO :: ONLY SELLER CAN ADD PRODUCTS
        $this->authorize('create', $product);
        $productCreated = $productServices->store($request, $product);
        return new ProductsResource($productCreated);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateProductsRequest $request, Products $product, ProductServices $service)
    {

        //TODO :: ONLY PRODUCTS INSTANTIATOR AND ADMIN CAN UPDATE (DONE)

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

        //TODO :: ONLY PRODUCTS INSTANTIATOR AND ADMIN CAN DELETE (DONE)


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
