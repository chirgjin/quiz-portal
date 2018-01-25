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
class USER
{
    static $_table;
    private $_pdo , $_data , $_changes , $_fetched;
    // public $id, $name, $email, $phone, $submitted, $starting_time, $team_name, $team_code, $marks;
    /**
     * Provides pdo connection to db
     *
     * @return void
     */
    private function _connectToDB()
    {
        if (!isset($this->_pdo)) {
            require __DIR__ . "/dbconfig.php";
            $this->_pdo = $pdo;
        }
    }

    /**
     * Constructor Function?
     *
     * @return void
     */
    public function __construct()
    {
        $this->_table   = "users";
        $this->_data    = array();
    }

    /**
     * Reset Changes
     *
     * @return void
     */
    public function resetChanges()
    {
        $this->_changes = array();
    }

    /**
     * Method - Get
     * returns value of variable requested
     *
     * @param string $prop Name of Property requested
     *
     * @return mixed $data Value of property
     */
    public function get($prop)
    {
        return isset($this->$prop) ? $this->$prop : null;
    }


    /**
     * Magic Method - Get
     * calls self.get
     *
     * @param string $prop Name of Property requested
     *
     * @return mixed $data Value of property
     */
    public function __get($prop)
    {
        return $this->get($prop);
    }


    /**
     * Magic Method - Set
     * sets the value of variable
     *
     * @param string  $prop  Name of Property
     * @param mixed   $val   Value of Property
     * @param boolean $store Whether to store the property in _changes variable so that it can be updated later via save()
     *
     * @return void
     */
    public function set($prop, $val, $store=1)
    {
        if($store && $this->get($prop) != $val)
            $this->_changes[$prop] = $val;

        $this->_data[$prop] = $this->$prop = $val;
        return $this;
    }

    public function __set($prop, $val)
    {
        $this->set($prop, $val);
    }

    /**
     * Fetch user from table depending upon supplied properties
     *
     * @return mixed self
     */
    public function fetch()
    {
        $this->_connectToDB();
        $sql = "";

        if ($this->get("id"))
            $sql .= "`id`=:id AND ";

        if ($this->get("name"))
            $sql .= "`name`=:name AND ";

        if ($this->get("email"))
            $sql .= "`email`=:email AND ";

        if ($this->get("phone"))
            $sql .= "`phone`=:phone AND ";

        if ($this->get("submitted"))
            $sql .= "`submitted`=:submitted AND ";

        if ($this->get("team_name"))
            $sql .= "`team_name`=:team_name AND ";

        if ($this->get("team_code"))
            $sql .= "`team_code`=:team_code AND ";

        if ($this->get("marks")) {
            $sql .= "`marks`";
            if (strpos($this->get("marks"), ">") === 0)
                $sql .= ">";
            else if (strpos($this->get("marks"), "<") === 0)
                $sql .= "<";
            else
                $sql .= "=";
        }

        if($sql == "")
            return 0;

        $sql = substr($sql, 0, -4);

        $stmt = $this->_pdo->prepare("SELECT * FROM `{$this->_table}` WHERE {$sql}");
        // var_dump($this->_data);
        $stmt->execute($this->_data);


        switch ($stmt->rowCount()) {
        case 0:
            return null;
            break;
        case 1:
            $obj = $stmt->fetchObject();

            foreach((array) $obj as $prop=>$val)
                $this->set($prop, $val, 0);

            $this->_fetched = 1;
            return $this;
            break;
        default:
            $objs = $stmt->fetchAll();

            $results = array();

            foreach ($objs as $obj) {
                $result = new USER;
                $result->_data = (array) $obj;
                $results[] = $result;
            }
            
            return $results;

            break;
        }
    }

    /**
     * Saves the details to database
     *
     * @param boolean $insert wether to insert new row in db
     *
     * @return mixed self
     */
    public function save($insert=0)
    {
        $this->_connectToDB();

        if($insert)
            return $this->insert();

        $sql = "";

        foreach ($this->_changes as $prop=>$val) {
            $sql .= "`{$prop}`=:{$prop} AND ";
        }

        if($sql == '')
            return $this;

        $this->_changes["id"] = $this->get("id");

        $stmt = $this->_pdo->prepare("UDPATE `{$this->_table}` SET {$sql} WHERE `id`=:id");

        $stmt->execute($this->_changes);

        $this->resetChanges();

        return $this;
    }

    /**
     * Insert the user to db
     *
     * @return false  on success
     * @return string on error
     */
    public function insert()
    {
        $this->_connectToDB();

        $columns = array_keys($this->_data);
        $vals    = preg_filter("/^/", ":", $columns);

        if(count($columns) < 1)
            return $this;

        $sql = "(" . implode(",", $columns) . ") VALUES (" . implode(",", $vals) . ")";

        $stmt = $this->_pdo->prepare("INSERT INTO `{$this->_table}` " . $sql);

        return $stmt->execute($this->_data) ? true : $stmt->errorInfo()[2];

    }

    /**
     * Check if user has extra privileges
     * 
     * @return boolean
     */
    public function isSuperUSer() {

        return $this->id == 1;

    }
}
