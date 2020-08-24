<?php 
    namespace controller;
    use repository, util;

    Class companyController {
       private $repository;

        public function __construct() {
            $this->repository = new repository\companyRepository();
        }

        public function register($username, $email, $password) {
            if(self::getCompanyByEmail($email) === NULL) {
                $id = $this->repository->getLastID();
                $company = new util\Company($id, $username, $email, $password, false);
                $success = $this->repository->addCompany($company);

                if($success) {
                    $_SESSION['Msg'] = "Account created";
                }
                else {  
                    $_SESSION['Error Msg'] = "Error occured while creating account";
                }
            }
            else {
                $_SESSION['Error Msg'] = "Sorry, email is used";
            } 
        }

        public function getCompanyByID($id){
            $company = $this->repository->getCompanyByID($id);
            return $company;
        }

        public function getCompanyByEmail($email){
            $company = $this->repository->getCompanyByEmail($email);
            return $company;
        }

        public function getCompanyList(){
            $companyList = $this->repository->getAllCompany();
            return $companyList;
        }

        public function edit($id, $username, $email, $password, $disabled) {
            $company = new util\Company($id, $username, $email, $password, $disabled);
            $success = $this->repository->updateCompany($company);

            if($success) {
                $_SESSION['Msg'] = "Account updated";
            }
            else {  
                $_SESSION['Error Msg'] = "Error occured while updating account";
            }
        }
    }
?>