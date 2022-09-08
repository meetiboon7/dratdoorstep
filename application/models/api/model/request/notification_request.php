<?php
/**
 * @OA\Schema(
 *      required={
 *          "token"
 *      }
 * )
 */
class PushNotificationRequest
{
    /**
     * @OA\Property()
     * in="header",
     * @var string
     */
    public $token;
    /**
     * @OA\Property()
    * @var string
     */
    public $device_id;
    /**
     * @OA\Property()
     * @var string
     */
    public $device_type;

    
}

