<?php


/**
 * @OA\Schema()
 */
class MemberProfile
{
    /**
     * @OA\Property
     * @var int
     */
    public $member_id;

    /**
     * @OA\Property
     * @var int
     */
    public $user_id;

    /**
     * @OA\Property
     * @var string
     */
    public $name;

    /**
     * @OA\Property
     * @var number
     */
    public $contact_no;

     
    /**
     * @OA\Property
     * @var int
     */
    public $city_id;

    /**
     * @OA\Property
     * @var string
     */
    public $gender;

    /**
     * @OA\Property
     * @var date
     */
    public $date_of_birth;

    /**
     * @OA\Property
     * @var string
     */
    public $mem_pic;
}
