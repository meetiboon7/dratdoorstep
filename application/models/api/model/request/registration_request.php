<?php

/**
 * @OA\Schema()
 */
class RegistrationRequest
{

    /**
     * @OA\Property()
     * @var string
     */
    public $email;

    /**
     * @OA\Property()
     * @var int
     */
    public $mobile;

    /**
     * @OA\Property()
     * @var int
     */
    public $pin; 

     /**
     * @OA\Property()
     * @var int
     */
    public $confirm_pin;    

    /**
     * @OA\Property()
     * @var string
     */
    public $referral_code;

     /**
     * @OA\Property()
     * @var int
     */
    public $city_id;
}
/**
 * @OA\Schema()
 */
class SocialRegistrationRequest
{

    /**
     * @OA\Property()
     * @var string
     */
    public $email;

    /**
     * @OA\Property()
     * @var int
     */
    public $mobile;

    /**
     * @OA\Property()
     * @var string
     */
    public $referral_code; 

    /**
     * @OA\Property()
     * @var int
     */
    public $city_id;  

   /**
     * @OA\Property()
     * @var string
     */
    public $device_type;
    /**
     * @OA\Property()
     * @var string
     */
    public $social_id;
    /**
     * @OA\Property()
     * @var string
     */
    public $social_type;
}
