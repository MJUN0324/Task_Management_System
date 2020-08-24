<?php 
    namespace controller;
    use repository;
    use util;

    if(!isset($_SESSION)) { 
        session_start(); 
    } 

    Class candidateController {
       private $repository;

        public function __construct() {
            $this->repository = new repository\candidateRepository();
        }

        public function register($username, $email, $password) {         
            if(self::getCandidateByEmail($email) === NULL) {
                $id = $this->repository->getLastID();
                $candidate = new util\Candidate($id, $username, $email, $password, false);
                $success = $this->repository->addCandidate($candidate);

                if($success) {
                    $_SESSION['Msg'] = "Account(s) created";
                }
                else {  
                    $_SESSION['Error Msg'] = "Error occured while creating account";
                }
            }
            else {
                $_SESSION['Error Msg'] = "Sorry, email is used";
            } 
        }

        public function registerInCSV($file) {         
            $filename = explode(".", $file);
            if ($filename[1] == 'csv') {
                $handle = fopen($_FILES['file']['tmp_name'], "r");
                $count = 1;          
                while ($data = fgetcsv($handle)) {
                    if($count == 1) {
                        $count++; 
                        continue;
                    }

                    $name = $data[0];
                    $email = $data[1];
                    $password = $data[2];

                    echo $name . " " . $email . " " . $password;

                    if ($name == '' || empty($name) || $email == '' || empty($email) || $password == '' || empty($password)){
                        // Skip for now
                    }
                    else {
                        self::register($name, $email, $password);
                    }

                }
                fclose($handle);
            }              

        }

        public function getCandidateByID($id){
            $candidate = $this->repository->getCandidateByID($id);
            return $candidate;
        }

        public function getCandidateByEmail($email){
            $candidate = $this->repository->getCandidateByEmail($email);
            return $candidate;
        }

        public function getCandidateList(){
            $candidateList = $this->repository->getAllCandidate();
            return $candidateList;
        }

        public function edit($id, $username, $email, $password, $disabled) {
            $candidate = new util\Candidate($id, $username, $email, $password, $disabled);
            $success = $this->repository->updateCandidate($candidate);

            if($success) {
                $_SESSION['Msg'] = "Account updated";
            }
            else {  
                $_SESSION['Error Msg'] = "Error occured while updating account";
            }
        }
    }
?>