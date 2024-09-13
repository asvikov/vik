<?php

namespace App\Services;


class GetUniqueDividedAddresses {

    /**
     * @param Collection $addresses
     * @return array
     */
    public static function getAll($addresses) {

        $addresses = $addresses->toArray();
        $cities = array_column($addresses, 'city');
        $cities = array_unique($cities);
        $streets = array_column($addresses, 'street');
        $streets = array_unique($streets);
        $houses = array_column($addresses, 'house');
        $houses = array_unique($houses);
        $apts = array_column($addresses, 'apt');
        $apts = array_unique($apts);
        $apts = array_filter($apts);

        $result = [
            'cities' => $cities,
            'streets' => $streets,
            'houses' => $houses,
            'apts' => $apts
        ];
        return $result;
    }
}
