<?php

namespace App\Classes;

use App\Models\Customer;

class Auth
{
    public static function user(): Customer
    {
        return Customer::firstOr(function () {
            return Customer::factory()->create();
        });
    }

}
