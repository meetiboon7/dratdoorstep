<?php

/**
 * @OA\Schema(
 *      required={
 *          "address_1",
 *          "address_2",
 *          "city_id",
 *          "state_id",
 *          "country_id",
 *          "pincode"
 *      }
 * )
 */
class AddressRequest
{
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
/**
 * @OA\Schema(
 *      required={
 *          "address_1",
 *          "address_2",
 *          "city_id",
 *          "state_id",
 *          "country_id",
 *          "pincode"
 *      }
 * )
 */
class AddressRequestUpdate
{

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
/**
 * @OA\Schema(
 *      required={
 *          "address_id"
 *      }
 * )
 */
class AddressRequestDelete
{
    /**
     * @OA\Property()
     * in="header",
     * @var int
     */
    public $address_id;

    
}
