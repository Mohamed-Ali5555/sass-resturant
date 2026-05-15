<?php

namespace App\Http\Requests\Vendor;

use App\Models\Restaurant;
use Illuminate\Foundation\Http\FormRequest;

abstract class VendorFormRequest extends FormRequest
{
    protected function vendorRestaurant(): Restaurant
    {
        /** @var Restaurant|null $restaurant */
        $restaurant = $this->attributes->get('vendorRestaurant');
        abort_if(! $restaurant instanceof Restaurant, 500, 'Vendor restaurant context missing.');

        return $restaurant;
    }

    public function authorize(): bool
    {
        return $this->user()?->can('viewVendor', $this->vendorRestaurant()) ?? false;
    }
}
