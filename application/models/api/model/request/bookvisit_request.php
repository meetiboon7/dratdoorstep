<?php

/**
 * @OA\Schema(
 *      required={

 
 *          "book_package_id",
 *          "date",
 *          "time"
 *      }
 * )
 */
class BookVisitRequest
{
    

     /**
     * @OA\Property()
     * @var int
     */
    public $book_package_id;

    

     /**
     * @OA\Property()
     * @var date
     */
    public $date;

     /**
     * @OA\Property()
     * @var string
     */
    public $time;
     




    

   
}
/**
 * @OA\Schema(
 * )
 */
class BookAppointRequestUpdate
{

   /**
     * @OA\Property()
     * @var date
     */
    public $date;

    /**
     * @OA\Property()
     * @var string
     */
    public $time;
}
/**
 * @OA\Schema(
 * )
 */
class BookPharmacyAppointmentRequestUpdate
{
   
    /**
     * @OA\Property()
     * @var string
     */
    public $contact_name;

    /**
     * @OA\Property()
     * @var number
     */
    public $contact_no;

    /**
     * @OA\Property()
     * @var string
     */
    public $landline_number;

     /**
     * @OA\Property()
     * @var int
     */
    public $city_id;

    /**
     * @OA\Property()
     * @var string
     */
    public $address;

    /**
     * @OA\Property(
     *  format="binary")
     * @var string
     */
    public $prescription;
}

/**
 * @OA\Schema(
 *      required={
         
 *          "service_id",
 *          "appointment_id"
 *      }
 * )
 */
class CancleAppointmentRequest
{
    /**
     * @OA\Property()
     * @var int
     */
    public $service_id;

    /**
     * @OA\Property()
     * @var int
     */
    public $appointment_id;

   

    


   
}

                       