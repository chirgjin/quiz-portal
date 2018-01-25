<?php

class QUESTION
{
        
    static $_table , $_fields;
    private $_data , $_changes , $_pdo;
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


    public function __construct() 
    {
        $this->_table = "questions";
        $this->_fields = array(
            "id",
            "question",
            "option1",
            "option2",
            "option3",
            "option4",
            "correct"
        );
        $this->_data = array();
        $this->_changes = array();
    }

    /**
     * Set/Get Options in form of array (option1,option2,option3,option4)
     * 
     * @param mixed $arr Array of Options(in Case of save)
     * 
     * @return mixed Array of options(in case of get) and self(in case of set)
     */
    public function options($arr=null) {
        if ($arr === null) {
            $arr = array(
                $this->get("option1"),
                $this->get("option2"),
                $this->get("option3"),
                $this->get("option4")
            );
            return $arr;
        }

        foreach ($arr as $index=>$option) {
            $this->set("option" . ($index+1), $option);
        }

        return $this;
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
        $this->_connectToDB();
        $sql = "";

        foreach ($this->_fields as $field) {
            if ($this->get($field))
                $sql .= "`{$field}`=:{$field} AND ";
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
     * @return true  on success
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

        var_dump($sql , $this->_data , $this->_changes);

        return $stmt->execute($this->_data) ? true : $stmt->errorInfo()[2];

    }
}

$q = new QUESTION;

$q->set("question", "How to extend jquery?")
    ->options(
        array(
            "$.extend",
            "$.fn.extend",
            "$.cs.extend",
            "extendJquery()"
        )
    )
    ->set("correct", 2)
    ->save(1);