<?php

namespace App\Services;

use App\Models\Products;
use App\Traits\ApiResponses;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ProductServices
{
    use ApiResponses;
    public function store($request, $product)
    {
        {
            try {
                $inserted = Products::create($request->validated());
                return $inserted;
            } catch (\Throwable $th) {
                return $th;
                return $this->error([
                    "message" => "Error when creating entry"
                ], 404);
            }
        }
    }
}
