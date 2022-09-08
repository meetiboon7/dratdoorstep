<?php

/**
 * @OA\Schema()
 */
class LoginResponse
{
    /**
     * @OA\Property
     * @var String
     */
    public $user_token;

    /**
     * @OA\Property
     * ref="#/components/schemas/User"
     * @var User
     */
    public $user;
}
