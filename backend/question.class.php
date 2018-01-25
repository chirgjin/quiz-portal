<?php

class QUESTION
{
        
    static $_table , $_fields;

    public function __construct() 
    {
        $this->_table = "questions";
        $this->_fields = array(
            ""
        );
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


    public function fetch()
    {
        
    }
}