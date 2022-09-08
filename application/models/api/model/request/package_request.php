<?php

/**
 * @OA\Schema(
 *      required={
         
 *          "patient_id",
 *          "address_id",
 *          "service_id",
 *          "package_id",
 *          "fees",
 *      }
 * )
 */
class PackageRequest
{
    /**
     * @OA\Property()
     * @var int
     */
    public $patient_id;

     /**
     * @OA\Property()
     * @var int
     */
    public $address_id;

    /**
     * @OA\Property()
     * @var int
     */
    public $user_id;

     /**
     * @OA\Property()
     * @var int
     */
    public $service_id;

     /**
     * @OA\Property()
     * @var int
     */
    public $package_id;

     /**
     * @OA\Property()
     * @var int
     */
    public $fees;

     




    

   
}


                       