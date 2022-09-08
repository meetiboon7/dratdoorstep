<?php

/**
 * @OA\Schema(
 *      required={
         
 *          "name",
 *          "contact_no",
 *          "city_id",
 *          "gender",
 *          "date_of_birth",
 *      }
 * )
 */
class MemberRequest
{
    /**
     * @OA\Property()
     * @var string
     */
    public $name;

    /**
     * @OA\Property()
     * @var number
     */
    public $contact_no;

    /**
     * @OA\Property()
     * @var int
     */
    public $city_id;

    /**
     * @OA\Property()
     * @var string
     */
    public $gender;

    /**
     * @OA\Property()
     * @var date
     */
    public $date_of_birth;

    /**
     * @OA\Property(
     *  format="binary")
     * @var string
     */
    public $mem_pic;
}
/**
 * @OA\Schema(
 *      required={
 *          "name",
 *          "contact_no",
 *          "city_id",
 *          "gender",
 *          "date_of_birth",
 *      }
 * )
 */
class MemberRequestUpdate
{

    /**
     * @OA\Property()
     * @var string
     */
    public $name;

    /**
     * @OA\Property()
     * @var number
     */
    public $contact_no;

    
    /**
     * @OA\Property()
     * @var int
     */
    public $city_id;

    /**
     * @OA\Property()
     * @var string
     */
    public $gender;

    /**
     * @OA\Property()
     * @var date
     */
    public $date_of_birth;

    /**
     * @OA\Property(
     *  format="binary")
     * @var string
     */
    public $mem_pic;
}
/**
 * @OA\Schema(
 *      required={
 *          "member_id"
 *      }
 * )
 */
class MemberRequestDelete
{
    /**
     * @OA\Property()
     * in="header",
     * @var int
     */
    public $member_id;

    
}
