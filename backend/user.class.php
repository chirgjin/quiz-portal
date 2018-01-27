<?php

/**
 * User Class
 *
 * @category Class
 * @package  QuizportalUserClass
 * @author   Chirgjin <chirgjin@gmail.com>
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
                "marks"
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
}
