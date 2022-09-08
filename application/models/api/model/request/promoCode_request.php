<?php

/**
 * @OA\Schema(
 *      required={
 *          "promo_code",
 *          "cart_id",
 *      }
 * )
 */
class PromoCodeRequest
{
    /**
     * @OA\Property()
     * @var string
     */
    public $promo_code;

    /**
     * @OA\Property(
     *  type="array",
     *      @OA\Items(
     *        type="integer",
     *        format="int32"
     *      ),
     *  )    
     */
    public $cart_id;

   

   
}
