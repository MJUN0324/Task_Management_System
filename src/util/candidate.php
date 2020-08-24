<?php 
    namespace util;

    Class Candidate extends Account {
        public function __construct($id, $username, $email, $password, $disabled) {   
            parent::__construct($id, $username, $email, $password, $disabled);
            $this->set_type("Candidate");
        }
    }
?>