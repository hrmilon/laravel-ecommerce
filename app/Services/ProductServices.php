<?php

namespace App\Services;

use App\Http\Resources\ProductsResource;
use App\Models\Products;
use App\Traits\ApiResponses;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class ProductServices
{
    use ApiResponses;
    public function store($request, $product)
    { {
            try {
                $data = $request->validated();
                $id = ["user_id" => Auth::user()->id];
                $result = array_merge($data, $id);

                $inserted = Products::create($result);
                return $inserted;
            } catch (\Throwable $th) {
                return $th;

                return $this->error([
                    "message" => "Error when creating entry"
                ], 404);
            }
        }
    }

    public function update($request, $product)
    { {
            try {
                $updated = $product->update($request->validated());
                return $updated;
            } catch (\Throwable $th) {
                return $th;
                return $this->error([
                    "message" => "Error when updating entry"
                ], 404);
            }
        }
    }


    public function show($product, $id)
    {
        try {
            $approvedProduct = Products::where('approved', '=', "1")->find($id);
            if (!$approvedProduct->exists()) {
                return;
            }

            return new ProductsResource($approvedProduct);
        } catch (\Throwable $th) {
            return $this->error([
                "message" => "Product is unavailable"
            ]);
        }
    }


    public function viewProductsPublic($products)
    {
        // return only approved products
        $approved = $products->where('approved', '=', "1");
        if (!$approved->exists()) {
            return response()->json([
                "message" => "No more products"
            ]);
        }

        return ProductsResource::collection($approved->cursorPaginate(10));
    }


    public function getAllProductsAdmin($products)
    {
        try {
            return ProductsResource::collection($products->paginate());
        } catch (\Throwable $th) {
            return $this->error([
                "message" => "Error during product fetch from Admin"
            ]);
        }
    }
}
