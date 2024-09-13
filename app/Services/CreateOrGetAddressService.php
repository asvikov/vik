<?php

namespace App\Services;

use App\Models\Address;

class CreateOrGetAddressService {

    /**
     * @param array $addresses
     */
    public static function getIdAddresses($addresses) {

        $addresses_id = [];

        foreach ($addresses as $address) {
            if(isset($address['apt'])) {
                $address_model = Address::where('city', $address['city'])->where('street', $address['street'])->where('house', $address['house'])->where('apt', $address['apt'])->first();
            } else {
                $address_model = Address::where('city', $address['city'])->where('street', $address['street'])->where('house', $address['house'])->first();
            }

            if(!$address_model) {
                $address_model = Address::create($address);
            }
            $addresses_id[] = $address_model->id;
        }

        return $addresses_id;
    }
}
