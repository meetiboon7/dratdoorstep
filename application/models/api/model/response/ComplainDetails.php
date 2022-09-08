<?php


/**
 * @OA\Schema()
 */
class ComplainDetails
{
    /**
     * @OA\Property
     * @var int
     */
    public $feedback_id;

    /**
     * @OA\Property
     * @var string
     */
    public $name;

    /**
     * @OA\Property()
     * @var string
     */
    public $email;

    /**
     * @OA\Property()
     * @var number
     */
    public $mobile;

    /**
     * @OA\Property()
     * @var int
     */
    public $feedback_services_id;

    /**
     * @OA\Property()
     * @var string
     */
    public $problem;

    /**
     * @OA\Property()
     * @var string
     */
    public $date;

    /**
     * @OA\Property()
     * @var int
     */
    public $user_id;

     /**
     * @OA\Property()
     * @var int
     */
    public $feedback_options_id;

   

}
