<?php


/**
 * @OA\Schema()
 */
class PackageResponse
{
    /**
     * @OA\Property
     * @var int
     */
    public $package_id;

    /**
     * @OA\Property
     * @var string
     */
    public $package_code;

    /**
     * @OA\Property
     * @var int
     */
    public $city_id;

     
    /**
     * @OA\Property
     * @var int
     */
    public $service_id;

    /**
     * @OA\Property
     * @var string
     */
    public $package_name;

    /**
     * @OA\Property
     * @var string
     */
    public $description;

    /**
     * @OA\Property
     * @var int
     */
    public $fees;

     /**
     * @OA\Property
     * @var number
     */
    public $no_visit;

    /**
     * @OA\Property
     * @var number
     */
    public $validate_day;

    /**
     * @OA\Property
     * @var date
     */
    public $purchase_date;

}
