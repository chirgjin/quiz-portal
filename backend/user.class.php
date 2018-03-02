<?php

require_once __DIR__ . "/base.class.php";

/**
 * User Class
 *
 * @category Class
 * @package  QuizportalUserClass
 * @license  idk idk
 * @link     backend/user.class.php
 */

/**
 * Contains all basic/necessary functions to make query on users table
 */
class USER extends BASE_MODEL
{
    /**
     * Constructor
     * Sets Table & Fields value
     */
    public function __construct() {
        parent::__construct("USER");
        parent::table("users");
        parent::fields(
            array(
                "id",
                "name",
                "email",
                "phone",
                "submitted",
                "starting_time",
                "team_name",
                "team_code",
                "marks",
                "rank"
            )
        );
    }

    /**
     * Check if user has extra privileges
     *
     * @return boolean
     */
    public function isSuperUSer()
    {

        return parent::get("is_admin") == 1;

    }

    /**
     * Get ending time
     */
    public function endTime() {
        parent::set("ending_time" , (int)parent::get("starting_time") + (int)setting_get("quiz_time"));

        return parent::get("ending_time");
    }

    /**
     * Get all submissions
     * 
     * @return array of SUBMISSIONs
     */
    public function submissions() {
        require_once(__DIR__ . "/submission.class.php");

        $submissions = new SUBMISSION;
        $submissions->user_id = parent::get("id");
        $results = $submissions->fetch();

        if( empty($results) || $results == null )
            return array();
        else if( !is_array($results) )
            $results = array( $results );
        
        return $results;
    }
}
