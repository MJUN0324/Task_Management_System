<?php 
    namespace controller;
    use repository;

    session_start();

    Class loginController {
        private $candidate_repository;
        private $company_repository;
        private $admin_repository;

        public function __construct() {
            $this->candidate_repository = new repository\candidateRepository();
            $this->company_repository = new repository\companyRepository();
            $this->admin_repository = new repository\adminRepository();
        }

        public function loginCheck($email, $password) {
            $candidate = $this->candidate_repository->getCandidateByEmail($email);
            $company = $this->company_repository->getCompanyByEmail($email);
            $admin = $this->admin_repository->getAdminByEmail($email);

            if(isset($candidate)) {
                if($candidate->get_password() === $password) {
                    $_SESSION["info"] = serialize($candidate);
                    $_SESSION["type"] = "candidate";
                    header("Location: http://". $_SERVER['HTTP_HOST'] . "/public/candidate/index.php");
                }
                else {
                    $_SESSION["errorMsg"] = "Password is not correct";
                }                
            }
            else if(isset($company)) {
                if($company->get_password() === $password) {
                    $_SESSION["info"] = serialize($company);
                    $_SESSION["type"] = "company";
                    header("Location: http://". $_SERVER['HTTP_HOST'] . "/public/company/index.php");
                }
                else {
                    $_SESSION["errorMsg"] = "Password is not correct";
                }
            }
            else if(isset($admin)) {
                if($admin->get_password() === $password) {
                    $_SESSION["info"] = serialize($admin);
                    $_SESSION["type"] = "admin";
                    header("Location: http://". $_SERVER['HTTP_HOST'] . "/public/admin/index.php");
                }
                else {
                    $_SESSION["errorMsg"] = "Password is not correct";
                }
            }
            else {
                $_SESSION["errorMsg"] = "Email not found";
            }
        }

        public function logout() {
            session_destroy();
            header("Location: http://". $_SERVER['HTTP_HOST'] . "/public/login.php");
        }
    }
?>