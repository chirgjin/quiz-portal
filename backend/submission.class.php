<?php
require_once __DIR__ . "/base.class.php";
/**
 * Question class
 * Add/Remove/Update Questions from db
 */
class SUBMISSION EXTENDS BASE_MODEL
{
    
    /**
     * Constructor
     * Provides tablename & fields to parent;
     */
    public function __construct() 
    {
        parent::__construct( get_class($this) );
        parent::table("user_submissions");
        parent::fields(
            array(
                "user_id",
                "ques_id",
                "answer"
            )
        );

    }

    public function calculateMarks() {
        
        $answer = parent::get("answer");

        if ($answer == 0) {
            return 0; //0 Marks for no answer
        }

        $question = new QUESTION;
        $question->id = parent::get("ques_id");
        $question->fetch();

        if ($question->answerIsCorrect($answer)) {
            return 2; //Positive Marks for Correct Answer
        } else {
            return -1; //Negative marks for Wrong Answer
        }
    }
}