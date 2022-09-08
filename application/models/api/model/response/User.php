<?php

/**
 * @OA\Schema()
 */
class User
{
    /**
     * @OA\Property
     * @var string
     */
    public $email;

    /**
     * @OA\Property
     * @var int
     */
    public $mobile;

    /**
     * @OA\Property
     * @var int
     */
    public $user_type_id;

    /**
     * @OA\Property
     * @var int
     */
    public $user_id;
}
