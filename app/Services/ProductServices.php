<?php

namespace App\Services;

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
}
