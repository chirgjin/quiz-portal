<?php
require_once __DIR__ . "/base.class.php";
/**
 * Submission class
 * Add/Remove/Update User Submissions from db
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
            return 1; //Positive Marks for Correct Answer
        } else {
            return 0; //Negative marks for Wrong Answer
        }
    }

    /**
     * Update Rows in db
     * 
     * @return void
     */
    public function update()
    {
        $sql = "UPDATE `" . parent::table() . "` SET `answer`=:answer WHERE `ques_id`=:ques_id AND `user_id`=:user_id";

        $data = array(
            "answer" => parent::get("answer"),
            "ques_id"=> parent::get("ques_id"),
            "user_id"=> parent::get("user_id"),
        );

        parent::query($sql, $data);

        return $this;
    }
}