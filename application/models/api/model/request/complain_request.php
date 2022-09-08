<?php

/**
 * @OA\Schema(
 *      required={
 *          "feedback_options_id",
 *          "feedback_services_id",
 *          "feedback"
 *      }
 * )
 */
class ComplainRequest
{
    /**
     * @OA\Property()
     * @var int
     */
    public $feedback_options_id;

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

    

   
}
