<?php

/**
 * @OA\Schema()
 */
class Registration_Response
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
