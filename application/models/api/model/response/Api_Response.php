<?php

/**
 * @OA\Schema()
 */
class Api_Response
{
    /**
     * @OA\Property
     * @var boolean
     */
    public $status;

    /**
     * @OA\Property
     * @var string
     */
    public $message;

    /**
     * @OA\Property
     * @var object
     */
    public $data;
}
