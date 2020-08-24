<?php 
    namespace repository;
    use util;

    Class companyRepository {

        public function __construct() {
        }

        public function addCompany(util\Company $company) {
            global $conn;

            $id = $company->get_id();
            $username = $company->get_username();
            $email = $company->get_email();
            $password = $company->get_password();


            $sql = "INSERT INTO company (companyID, name, email, password)
                    VALUES
                        (
                            '$id',
                            '$username',
                            '$email',
                            '$password'
                        )
                    ";

            mysqli_query($conn,$sql);

            if(mysqli_affected_rows($conn)>0){
               return true;
            } 
        }

        public function getCompanyByID($id) {
            global $conn;

            $company = null;
            $sql = "SELECT * FROM company WHERE companyID = '$id'";

            $result = mysqli_query($conn,$sql);
            if($record = mysqli_fetch_assoc($result)) {    
                $company = new util\Company($record['companyID'], $record['name'], $record['email'], $record['password'], $record['disabled']);
            }

            return $company;
        }

        public function getCompanyByEmail($email) {
            global $conn;

            $company = null;
            $sql = "SELECT * FROM company WHERE email = '$email' AND disabled = 0";

            $result = mysqli_query($conn,$sql);
            if($record = mysqli_fetch_assoc($result)) {
                $company = new util\Company($record['companyID'], $record['name'], $record['email'], $record['password'], $record['disabled']);
            }
            
            return $company;
        }

        public function getAllCompany() {
            global $conn;

            $companyList = [];

            $sql = "SELECT * FROM company";

            $result = mysqli_query($conn,$sql);
            while($record = mysqli_fetch_assoc($result)) {
                $company = new util\Company($record['companyID'], $record['name'], $record['email'], $record['password'], $record['disabled']);
                array_push($companyList, $company);
            }

            return $companyList;
        }

        public function updateCompany(util\Company $company) {
            global $conn;

            $id = $company->get_id();
            $username = $company->get_username();
            $email = $company->get_email();
            $password = $company->get_password();
            $disabled = $company->is_disabled();

            $sql = "UPDATE company 
                    SET name = '$username',
                        email = '$email',
                        password = '$password',
                        disabled = '$disabled'
                    WHERE companyID='$id'
                    ";

            mysqli_query($conn,$sql);

            if(mysqli_affected_rows($conn)>0){
               return true;
            } 
        }

        public function getLastID() {
            global $conn;

            $sql = "SELECT MAX(companyID) AS companyID FROM company;";
            $result = mysqli_query($conn, $sql);
            $record = mysqli_fetch_assoc($result);

            $company_last_id = "CO0000";
            if ($record["companyID"] !== NULL)
                $company_last_id = $record["companyID"];

            $company_last_id++;

            return $company_last_id;
        }
    }
?>