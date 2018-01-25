<?php

class QUESTION
{
        
    const _table = "questions" , _fields = array(
        "id",
        "question",
        "option1",
        "option2",
        "option3",
        "option4",
        "correct"
    );
    private $_data , $_changes , $_pdo , $_fetched;
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
     * Check if provided answer is correct
     * 
     * @param int/string $answer Answer Selected by User (0-4) / Option String
     * 
     * @return boolean 
     */
    public function answerIsCorrect($answer)
    {

        if (is_numeric($answer)) {
            if ($answer == 0)
                return false;
            else
                return $this->get("correct") == $answer;
        } else {

            $option = $this->get("option" . $this->get("correct"));
            $regex = "/^" . preg_quote($answer, "\/") . '$/i';

            if (preg_match($regex , $option))
                return true;
            else
                return false;
            
            $options = $this->options();

            if (in_array($answer, $options))
                return true;
            

            foreach ($options as $option) {
                if (preg_match($regex, $option))
                    return true;
            }

            return false;
        }
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
        //var_dump($prop , $val , $this->_fields);
        if($store && $this->get($prop) != $val && in_array($prop, QUESTION::_fields))
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

        foreach (QUESTION::_fields as $field) {
            if ($this->get($field))
                $sql .= "`{$field}`=:{$field} AND ";
        }

        if($sql == "")
            return 0;

        $sql = substr($sql, 0, -4);

        $stmt = $this->_pdo->prepare("SELECT * FROM `" . QUESTION::_table . "` WHERE {$sql}");
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
                $result->_fetched = 1;
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

        $stmt = $this->_pdo->prepare("UDPATE `" . QUESTION::_table . "` SET {$sql} WHERE `id`=:id");

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

        $stmt = $this->_pdo->prepare("INSERT INTO `" . QUESTION::_table . "` " . $sql);

        var_dump($sql , $this->_data , $this->_changes);

        return $stmt->execute($this->_data) ? true : $stmt->errorInfo()[2];

    }
}

/*
$q = new QUESTION;

$q->set("question", "How to extend jquery?")->fetch();
var_dump($q->answerIsCorrect(0));
var_dump($q->answerIsCorrect("$.fn.extend"));
*/