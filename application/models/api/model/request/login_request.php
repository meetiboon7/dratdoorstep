<?php

/**
 * @OA\Schema()
 */
class LoginRequest
{

    /**
     * @OA\Property()
     * @var string
     */
    public $email_or_mobile;

    /**
     * @OA\Property()
     * @var int
     */
    public $pin;
}

/**
 * @OA\Schema()
 */
class SocialLoginRequest
{

    /**
     * @OA\Property()
     * @var string
     */
    public $email_or_mobile;

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

/**
 * @OA\Schema()
 */
class ForgotRequest
{

    /**
     * @OA\Property()
     * @var string
     */
    public $email_or_mobile;

  
}

/**
 * @OA\Schema(
 *      required={
 *          "old_pin",
 *          "new_pin",
 *          "confirm_pin"
 *      }
 * )
 */
class ChangePasswordRequest
{

    /**
     * @OA\Property()
     * @var int
     */
    public $old_pin;

    /**
     * @OA\Property()
     * @var int
     */
    public $new_pin;

    /**
     * @OA\Property()
     * @var int
     */
    public $confirm_pin;

  
}