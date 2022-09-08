<?php


/**
 * @OA\Schema()
 */
class ProfileRequestUpdate
{

    /**
     * @OA\Property()
     * @var string
     */
    public $first_name;

    /**
     * @OA\Property()
     * @var number
     */
    public $last_name;

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
     * @OA\Property(
     *  format="binary")
     * @var string
     */
    public $profile_pic;
}

