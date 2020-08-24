<?php 
    namespace util;

    class Account {
        private $type;
        private $id;
        private $username;
        private $email;
        private $password;
        private $disabled;

        public function __construct($id, $username, $email, $password, $disabled) {   
            $this->set_id($id);
            $this->set_username($username);
            $this->set_email($email);
            $this->set_password($password);
            $this->set_disabled($disabled);
        }

        public function get_type() {
            return $this->type;
        }
    
        public function set_type($type) {
            $this->type = $type;
        }

        public function get_id() {
            return $this->id;
        }
    
        public function set_id($id) {
            $this->id = $id;
        }

        public function get_username() {
            return $this->username;
        }
    
        public function set_username($username) {
            $this->username = $username;
        }
    
        public function get_email() {
            return $this->email;
        }
    
        public function set_email($email) {
            $this->email = $email;
        }
    
        public function get_password() {
            return $this->password;
        }
    
        public function set_password($password) {
            $this->password = $password;
        }

        public function is_disabled() {
            return $this->disabled;
        }

        public function set_disabled($disabled) {
            $this->disabled = $disabled;
        }
    }
?>