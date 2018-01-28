<?php

require_once __DIR__ . "/base.class.php";
/**
 * Question class
 * Add/Remove/Update Questions from db
 */
class QUESTION EXTENDS BASE_MODEL
{
    
    /**
     * Constructor
     * Provides tablename & fields to parent;
     */
    public function __construct() 
    {
        parent::__construct( get_class($this) );
        parent::table("questions");
        parent::fields(
            array(
                "id",
                "question",
                "option1",
                "option2",
                "option3",
                "option4",
                "correct"
            )
        );

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
     * Function to load a random row from DB
     * 
     * @param int $number number of records to return
     * 
     * @return array self
     */
    public function loadRandom($number)
    {
        //Wrrite some code here..

        $sql = "SELECT * FROM `" . parent::table() . "` ORDER BY RAND() LIMIT 0,{$number}";

        $stmt = parent::query($sql, array());

        $objs = array();
        
        foreach ($stmt->fetchAll() as $obj) {
            $ques = new QUESTION;
            foreach((array)$obj as $key=>$val)
                $ques->$key = $val;
            $objs[] = $ques;
        }

        return $objs;
    }
}

/*
$q = new QUESTION;

$q->set("question", "How to extend jquery?")->fetch();
var_dump($q->answerIsCorrect(0));
var_dump($q->answerIsCorrect("$.fn.extend"));
*/