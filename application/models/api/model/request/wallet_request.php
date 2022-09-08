<?php

/**
 * @OA\Schema(
 *      required={
 *          "amount"
 *      }
 * )
 */
class PaymentWalletGetwayRequest
{
    /**
     * @OA\Property()
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
class SetWalletPaymentRequest
{
    /**
     * @OA\Property()
     * @var object
     */
    public $payment_request;

    
}
