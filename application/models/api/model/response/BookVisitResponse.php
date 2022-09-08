<?php


/**
 * @OA\Schema()
 */
class BookVisitResponse
{

     
    /**
     * @OA\Property
     * @var int
     */
    public $book_package_id;

    

    /**
     * @OA\Property
     * @var date
     */
    public $date;

    /**
     * @OA\Property
     * @var string
     */
    public $time;

   

}
