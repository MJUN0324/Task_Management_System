<?php 
    namespace util;

    class Result {
        private $taskID;
        private $candidateID;
        private $answer;
        private $status;
        private $marks;
        private $grade;
        private $comment;
        
        public function __construct($taskID, $candidateID, $answer, $status, $marks, $grade, $comment) {
            $this->set_task_id($taskID);
            $this->set_candidate_id($candidateID);
            $this->set_answer($answer);
            $this->set_status($status);
            $this->set_marks($marks);
            $this->set_grade($grade);
            $this->set_comment($comment);
        }

        public function get_task_id() {
            return $this->taskID;
        }
    
        public function set_task_id($taskID) {
            $this->taskID = $taskID;
        }
        
        public function get_candidate_id() {
            return $this->candidateID;
        }
    
        public function set_candidate_id($candidateID) {
            $this->candidateID = $candidateID;
        }

        public function get_answer() {
            return $this->answer;
        }
    
        public function set_answer($answer) {
            $this->answer = $answer;
        }

        public function get_status() {
            return $this->status;
        }
    
        public function set_status($status) {
            $this->status = $status;
        }

        public function get_marks() {
            return $this->marks;
        }
    
        public function set_marks($marks) {
            $this->marks = $marks;
        }

        public function get_grade() {
            return $this->grade;
        }
    
        public function set_grade($grade) {
            $this->grade = $grade;
        }

        public function get_comment() {
            return $this->comment;
        }
    
        public function set_comment($comment) {
            $this->comment = $comment;
        }
    }
?>