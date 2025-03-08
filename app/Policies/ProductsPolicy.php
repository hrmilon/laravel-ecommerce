<?php

namespace App\Policies;

use App\Models\Admin;
use App\Models\Products;
use App\Models\User;

class ProductsPolicy
{

    public function viewAny()
    {
        return true;
    }

    /**
     * Determine whether the user can create models.
     */
    public function create($user, Products $products): bool
    {
        // admin cant post products
        if ($user instanceof Admin) {
            return false;
        }

        if ($user instanceof User) {
            return true;
        }

        return false;
    }

    /**
     * Determine whether the user can update the model.
     */
    public function update($user, products $products): bool
    {
        if ($user instanceof Admin) {
            return true;
        }

        if ($user instanceof User) {
            return $user->id == $products->user_id;
        }

        return false;
    }

    /**
     * Determine whether the user can delete the model.
     */
    public function delete($user, products $products): bool
    {
        if ($user instanceof Admin) {
            return true;
        }

        if ($user instanceof User) {
            return $user->id == $products->user_id;
        }

        return false;
    }
}
