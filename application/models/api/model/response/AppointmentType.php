<?php


/**
 * @OA\Schema()
 */
class AppointmentType
{
    /**
     * @OA\Property
     * @var int
     */
    public $patient_id;

    /**
     * @OA\Property
     * @var int
     */
    public $user_id;

    /**
     * @OA\Property
     * @var int
     */
    public $doctor_type_id;

    /**
     * @OA\Property
     * @var date
     */
    public $date;

      /**
     * @OA\Property
     * @var string
     */
    public $time;


    /**
     * @OA\Property
     * @var string
     */
    public $prescription;

   
}

/**
 * @OA\Schema()
 */
class PharmacyType
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


