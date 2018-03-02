<?php

date_default_timezone_set("Asia/Kolkata");

/**
 * Base Model for all classes
 * Provides db related functions
 *
 */
class BASE_MODEL
{
    private $_table , $_fields , $_data , $_changes , $_pdo , $_fetched , $_className;
    public $error;

    /**
     * Constructor fnc?
     *
     * @param string $className ClassName of children
     */
    public function __construct($className=null) {
        $this->_data = array();
        $this->_changes = array();
        $this->_fetched = 0;
        $this->error = 0;
        $this->_className = $className;
    }

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
     * Get/Set $this->_table
     *
     * @param string $table Value of Table
     *
     * @return string/void
     */
    public function table($table=null)
    {
        if ($table != null)
            $this->_table = $table;
        else
            return $this->_table;

    }

    /**
     * Get/Set Fields
     *
     * @param mixed $fields Fields to add
     */
    public function fields($fields=null)
    {

        if ($fields == null)
            return $this->_fields;
        else {
            foreach($fields as $f)
                $this->addField($f);
        }
    }

    /**
     * Add new field to model
     *
     * @param string $field Field Name
     *
     * @return void
     */
    public function addField($field) {
        $this->_fields[] = $field;
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
        return isset($this->_data[$prop]) ? $this->_data[$prop] : null;
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

        $this->_data[$prop] = $val;
        return $this;
    }

    /**
     * Magic Method Set
     *
     * @param string $prop property
     * @param mixed  $val  value
     *
     * @return void
     */
    public function __set($prop, $val)
    {
        $this->set($prop, $val);
    }

    /**
     * Perform Query on Db
     *
     * @param string $sql  SQL Statement to execute
     * @param mixed  $data Data to pass to PDO
     *
     * @return PDOSTATEMENT
     */
    public function query($sql,$data)
    {
        $this->_connectToDB();

        $stmt = $this->_pdo->prepare($sql);

        $stmt->execute($data);

        if($stmt->errorCode() === '00000')
            $this->error = 0;
        else {
            $this->error = new stdClass;
            $error = $stmt->errorInfo();

            $this->error->sql_code = $error[0];
            $this->error->driver_code = $error[1];
            $this->error->message     = $error[2];
        }

        return $stmt;
    }

    /**
     * Fetch Row(s) from db
     *
     * @return mixed null/self/multiple rows
     */
    public function fetch()
    {
        $this->_connectToDB();
        $sql = "";
        $data = array(
            //"_table" => $this->_table
        );

        foreach ($this->_fields as $field) {
            if ($this->get($field)) {
                $sql .= "`{$field}`=:{$field} AND ";
                $data[$field] = $this->get($field);
            }
        }

        if ($sql == "")
            return 0;

        $sql = substr($sql, 0, -4); //remove "AND " from query

        $sql = "SELECT * FROM `{$this->_table}` WHERE {$sql}"; //final query
        // var_dump($this->_data);

        $stmt = $this->query($sql, $data);

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
            $classname = ($this->_className);

            foreach ($objs as $obj) {
                $result = new $classname;
                $result->_data = (array) $obj;
                $result->_fetched = 1;
                $results[] = $result;
            }

            return $results;

            break;
        }
    }

    /**
     * Fetch all rows from db
     * Doesn't use WHERE clause
     *
     * @return mixed array_of_rows
     */
    public function fetchAll()
    {
        $stmt = $this->query("SELECT * FROM `{$this->_table}`", array());

        $objs = $stmt->fetchAll();

        $results = array();
        $classname = $this->_className;

        foreach ($objs as $obj) {
            $result = new $classname;
            $result->_data = (array) $obj;
            $result->_fetched = 1;
            $results[] = $result;
        }

        return $results;
    }

    /**
     * Update Rows in db
     *
     * @return void
     */
    public function update()
    {
        $sql = "";
        $data = array(
            //"_table" => $this->_table
        );

        foreach ($this->_changes as $prop=>$val) {
            if(!in_array($prop,$this->_fields))
                continue;
            $sql .= "`{$prop}`=:{$prop} , ";
            $data[$prop] = $this->get($prop);
        }

        if($sql == '')
            return $this;
        $data["id"] = $this->get("id");

        $sql = substr($sql , 0 , -2); //Remove ", "

        $sql = "UPDATE `{$this->_table}` SET {$sql} WHERE `id`=:id";

        $this->query($sql, $data);

        $this->resetChanges();

        return $this;
    }

    /**
     * Insert the question to db
     *
     * @return true  on success
     */
    public function insert()
    {
        $columns = array_keys($this->_data);
        $vals    = preg_filter("/^/", ":", $columns);

        if (count($columns) < 1)
            return $this;

        $sql = "(" . implode(",", $columns) . ") VALUES (" . implode(",", $vals) . ")";

        $sql = "INSERT INTO `{$this->_table}` " . $sql;
        //$vals["_table"] = $this->_table;

        //var_dump($sql , $this->_data , $this->_changes);

        return $this->query($sql, $this->_data);

    }

    /**
     * Delete row from table
     * 
     * @return self
     */
    public function delete()
    {
        if (!$this->get("id")) {
            return ; //Don't delete if there's no id present.. (Considers id to be primary & thus SUBMISSION table needs a separate fnc override)
        }
        
        $sql = "DELETE FROM `{$this->_table}` WHERE `id`=:id";
        $data = array("id"=>$this->get("id"));

        $stmt = $this->query($sql, $data);

        return $this;
    }
}