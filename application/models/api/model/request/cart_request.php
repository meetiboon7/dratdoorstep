<?php
/**
 * @OA\Schema(
 *      required={
 *          "cart_id"
 *      }
 * )
 */
class CartRequestDelete
{
    /**
     * @OA\Property()
     * in="header",
     * @var int
     */
    public $cart_id;

    
}
/**
 * @OA\Schema(
 * )
 */
class DoctorCartRequestUpdate
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
 * )
 */
class NurseCartRequestUpdate
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
}
/**
 * @OA\Schema(
 * )
 */
class LabCartRequestUpdate
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
 * )
 */
class OneWayCartRequestUpdate
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
 * )
 */
class MultiLocationCartRequestUpdate
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
 *          "amount"
 *      }
 * )
 */
class PaymentGetwayRequest
{
    /**
     * @OA\Property()
     * in="header",
     * @var string
     */
    public $amount;

   

    
}

/**
 * @OA\Schema(
 *      required={
 *          "payment_request"
 *      }
 * )
 */
class SetPaymentResponse
{
    /**
     * @OA\Property()
     * @var object
     */
    public $payment_request;

    /**
     * @OA\Property()
     * @var boolean
     */
    public $is_wallet_selected;
     /**
     * @OA\Property()
     * in="header",
     * @var string
     */
    public $discount;
     /**
     * @OA\Property()
     * in="header",
     * @var int
     */
    public $voucher_id;

    
}
