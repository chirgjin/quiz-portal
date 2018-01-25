<?php

//Start Session & Session Related Functions

if (!isset($_SESSION)) {
    session_start();
}

/**
 * Session Class to Manage User Sessions
 * 
 * @category CLASS
 * @package  SESSIONCLASS
 * @author   chirgjin <chirgjin@gmail.com>
 */

class SESSION
{
    public $user;

    /**
     * Constructor?
     */
    public function __construct()
    {
        if (func_num_args() > 0) {
            $this->user(func_get_arg(0));
        }
    }

    /**
     * Get/Set User Property
     * 
     * @param mixed $user User variable (optional)
     * 
     * @return mixed Self/User
     */
    public function user($user=null)
    {
        if ($user != null) {
            $this->user = $user;
            return $this;
        } else {
            return $this->user;
        }
    }

    public function start($id=null)
    {
        if($id === null)
            $id = $this->user()->id;
        else if(is_object($id))
            $id = $id->id;
        
        $_SESSION['id'] = $id;

        return $this;
    }

    public function verify()
    {
        $id = $this->getID();
        //header("ID:{$id}");
        
        $user = new USER();
        $user->set("id", $id);

        if ($user->fetch()) {
            $this->user($user);
            return true;
        } else {
            return false;
        }

    }

    public function destory() {
        $this->user(0);
        unset($_SESSION['id']);
    }

    public function getID()
    {
        return isset($_SESSION['id']) ? $_SESSION['id'] : 0;
    }
}