<?php 
    namespace util;

    class Task {
        private $taskID;
        private $taskName;
        private $companyID;
        private $start;
        private $end;
        private $attemptTime;
        private $attemptLimit;
        private $description;
        private $question;
        private $fileList;
        private $candidateList;
        private $disabled;

        public function __construct($taskID, $taskName, $companyID, $start, $end, $attemptTime, $attemptLimit, $description, $question) {   
            $this->set_task_id($taskID);
            $this->set_task_name($taskName);
            $this->set_company_id($companyID);
            $this->set_start($start);
            $this->set_end($end);
            $this->set_attempt_time($attemptTime);
            $this->set_attempt_limit($attemptLimit);
            $this->set_description($description);
            $this->set_question($question);
        }

        public function get_task_id() {
            return $this->taskID;
        }
    
        public function set_task_id($taskID) {
            $this->taskID = $taskID;
        }

        public function get_task_name() {
            return $this->taskName;
        }
    
        public function set_task_name($taskName) {
            $this->taskName = $taskName;
        }
        
        public function get_company_id() {
            return $this->companyID;
        }
    
        public function set_company_id($companyID) {
            $this->companyID = $companyID;
        }

        public function get_start() {
            return $this->start;
        }
    
        public function set_start($start) {
            $this->start = $start;
        }

        public function get_end() {
            return $this->end;
        }
    
        public function set_end($end) {
            $this->end = $end;
        }

        public function get_attempt_time() {
            return $this->attemptTime;
        }
    
        public function set_attempt_time($attemptTime) {
            $this->attemptTime = $attemptTime;
        }

        public function get_attempt_limit() {
            return $this->attemptLimit;
        }
    
        public function set_attempt_limit($attemptLimit) {
            $this->attemptLimit = $attemptLimit;
        }

        public function get_description() {
            return $this->description;
        }
    
        public function set_description($description) {
            $this->description = $description;
        }

        public function get_question() {
            return $this->question;
        }
    
        public function set_question($question) {
            $this->question = $question;
        }

        public function get_file_list() {
            return $this->fileList;
        }
    
        public function set_file_list($fileList) {
            $this->fileList = $fileList;
        }

        public function get_candidate_list() {
            return $this->candidateList;
        }
    
        public function set_candidate_list($candidateList) {
            $this->candidateList = $candidateList;
        }

        public function is_disabled() {
            return $this->disabled;
        }

        public function set_disabled($disabled) {
            $this->disabled = $disabled;
        }
    }
?>