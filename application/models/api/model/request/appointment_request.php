<?php

/**
 * @OA\Schema(
 *      required={
         
 *          "patient_id",
 *          "address_id",
 *          "doctor_type_id",
 *          "date",
 *          "time"
 *      }
 * )
 */
class DoctorRequest
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
     * @var string
     */
    public $complain;
    /**
     * @OA\Property()
     * @var int
     */
    public $doctor_type_id;

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
 *      required={
         
 *          "patient_id",
 *          "address_id",
 *          "doctor_type_id",
 *          "date",
 *          "time"
 *      }
 * )
 */
class NurseRequest
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
     * @var string
     */
    public $complain;
    /**
     * @OA\Property()
     * @var int
     */
    public $nurse_service_id;

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

    /**
     * @OA\Property()
     * @var int
     */
    public $days;

   
}
/**
 * @OA\Schema(
 *      required={
         
 *          "patient_id",
 *          "address_id",
 *          "lab_test_id",
 *          "date",
 *          "time",
 *      }
 * )
 */
class LabRequest
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
    public $lab_test_id;

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

   /**
     * @OA\Property()
     * @var string
     */
    public $complain;

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
         
 *          "contact_name",
 *          "contact_no",
 *          "city_id",
 *          "address",
 *          "prescription"
 *      }
 * )
 */
class PharmacyRequest
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
         
 *          "patient_id",
 *          "city_id",
 *          "from_address",
 *          "to_address",
 *          "start_date",
 *          "start_time"
 *      }
 * )
 */
class AmbulanceOneWay
{
    /**
     * @OA\Property()
     * @var int
     */
    public $patient_id;


    /**
     * @OA\Property()
     * @var number
     */
    public $mobile_no;

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
    public $from_address;

    /**
     * @OA\Property()
     * @var string
     */
    public $to_address;

    

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
 *      required={
         
 *          "patient_id",
 *          "city_id",
 *          "date",
 *          "time",
  *         "multi_location",
 *      }
 * )
 */
class AmbulanceMultiLocation
{
    /**
     * @OA\Property()
     * @var int
     */
    public $patient_id;

    /**
     * @OA\Property()
     * @var number
     */
    public $mobile_no;

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
     * @var date
     */
    public $date;

     /**
     * @OA\Property()
     * @var string
     */
    public $time;

    /**
     * @OA\Property()
     * @var string
     */
    public $multi_location;

    


   
}
/**
 * @OA\Schema(
 *      required={
         
 *          "service_id",
 *          "appointment_id"
 *      }
 * )
 */
class VisitAppointmentRequest
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

