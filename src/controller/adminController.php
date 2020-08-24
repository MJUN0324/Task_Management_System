<?php 
    namespace controller;
    use repository, util;

    Class adminController {
       private $repository;

        public function __construct() {
            $this->repository = new repository\adminRepository();
        }

        public function register($username, $email, $password) {
            if(self::getAdminByEmail($email) === NULL) {
                $id = $this->repository->getLastID();
                $admin = new util\Admin($id, $username, $email, $password, false);
                $success = $this->repository->addAdmin($admin);

                if($success) {
                    if($this->send_mail($username, $email, $password)){
                        $_SESSION['Msg'] = "Account created";
                    }     
                    else {
                        echo error_get_last()['message'];
                    }              
                }
                else {  
                    $_SESSION['Error Msg'] = "Error occured while creating account";
                }
            }
            else {
                $_SESSION['Error Msg'] = "Sorry, email is used";
            } 
        }

        public function getAdminByID($id){
            $admin = $this->repository->getAdminByID($id);
            return $admin;
        }

        public function getAdminByEmail($email){
            $admin = $this->repository->getAdminByEmail($email);
            return $admin;
        }

        public function getAdminList(){
            $adminList = $this->repository->getAllAdmin();
            return $adminList;
        }

        public function edit($id, $username, $email, $password, $disabled) {
            $admin = new util\Admin($id, $username, $email, $password, $disabled);
            $success = $this->repository->updateAdmin($admin);

            if($success) {
                $_SESSION['Msg'] = "Account updated";
            }
            else {  
                $_SESSION['Error Msg'] = "Error occured while updating account";
            }
        }

        public function send_mail($username, $email, $password) {
            $to_email = 'taihoyin19991999@gmail.com';
            $subject = 'HKVEP Online Test - Registeration success';
            $message = 'Dear ' . $username . ',\n\nThank you for using Hong Kong Vocational English Programme (HKVEP) Online Task System.\n\n\tYour account is:' . $email . '\n\tPassword is :' . $password . '\n\nRegards,\nHKVEP\n\nThis mail is sent by system automatically. DO NOT REPLY.';
            $headers = 'From: hkvep.noreply@gmail.com';
            $success = mail($to_email,$subject,$message,$headers);
            return $success;
        }
    }
?>