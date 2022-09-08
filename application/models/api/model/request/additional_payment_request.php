<?php

/**
 * @OA\Schema(
 *      required={
 *          "amount"
 *      }
 * )
 */
class AdditionalPaymentGetwayRequest
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
class AdditionalSetPaymentResponse
{
    /**
     * @OA\Property()
     * @var object
     */
    public $payment_request;

    /**
     * @OA\Property()
     * @var int
     */
    public $user_type_id;
     /**
     * @OA\Property()
     * @var int
     */
    public $id;
      /**
     * @OA\Property()
     * @var int
     */
    public $appointment_id;

    
}

/**
 * @OA\Schema(
 *      required={
 *          "payment_request"
 *      }
 * )
 */
class SetPendingPaymentResponse
{
    /**
     * @OA\Property()
     * @var object
     */
    public $payment_request;

    /**
     * @OA\Property()
     * @var int
     */
    public $user_type_id;
    
      /**
     * @OA\Property()
     * @var int
     */
    public $appointment_id;

    
}

