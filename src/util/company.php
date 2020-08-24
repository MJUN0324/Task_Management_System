<?php 
    namespace util;

    Class Company extends Account {
        public function __construct($id, $username, $email, $password, $disabled) {   
            parent::__construct($id, $username, $email, $password, $disabled);
            $this->set_type("Company");
        }
    }
?>