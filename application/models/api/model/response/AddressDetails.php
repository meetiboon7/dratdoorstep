<?php


/**
 * @OA\Schema()
 */
class AddressDetails
{
    /**
     * @OA\Property
     * @var int
     */
    public $address_id;

    /**
     * @OA\Property
     * @var int
     */
    public $user_id;

    /**
     * @OA\Property()
     * @var string
     */
    public $address_1;

    /**
     * @OA\Property()
     * @var string
     */
    public $address_2;

    /**
     * @OA\Property()
     * @var int
     */
    public $city_id;

    /**
     * @OA\Property()
     * @var int
     */
    public $state_id;

    /**
     * @OA\Property()
     * @var int
     */
    public $country_id;

    /**
     * @OA\Property()
     * @var int
     */
    public $pincode;
}
