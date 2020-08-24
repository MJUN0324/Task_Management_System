<?php 
    namespace repository;
    use util;

    Class adminRepository {

        public function __construct() {
        }

        public function addAdmin(util\Admin $admin) {
            global $conn;

            $id = $admin->get_id();
            $username = $admin->get_username();
            $email = $admin->get_email();
            $password = $admin->get_password();


            $sql = "INSERT INTO admin (adminID, name, email, password)
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

        public function getAdminByID($id) {
            global $conn;

            $admin = null;
            $sql = "SELECT * FROM admin WHERE adminID = '$id'";

            $result = mysqli_query($conn,$sql);
            if($record = mysqli_fetch_assoc($result)) {
                $admin = new util\Admin($record['adminID'], $record['name'], $record['email'], $record['password'], $record['disabled']);
            }

            return $admin;
        }

        public function getAdminByEmail($email) {
            global $conn;

            $admin = null;
            $sql = "SELECT * FROM admin WHERE email = '$email' AND disabled = 0";

            $result = mysqli_query($conn,$sql);
            if($record = mysqli_fetch_assoc($result)) {
                $admin = new util\Admin($record['adminID'], $record['name'], $record['email'], $record['password'], $record['disabled']);
            }

            return $admin;
        }

        public function getAllAdmin() {
            global $conn;

            $adminList = [];

            $sql = "SELECT * FROM admin";

            $result = mysqli_query($conn,$sql);
            while($record = mysqli_fetch_assoc($result)) {
                $admin = new util\Admin($record['adminID'], $record['name'], $record['email'], $record['password'], $record['disabled']);
                array_push($adminList, $admin);
            }

            return $adminList;
        }

        public function updateAdmin(util\Admin $admin) {
            global $conn;

            $id = $admin->get_id();
            $username = $admin->get_username();
            $email = $admin->get_email();
            $password = $admin->get_password();
            $disabled = $admin->is_disabled();

            $sql = "UPDATE admin 
                    SET name = '$username',
                        email = '$email',
                        password = '$password',
                        disabled = '$disabled'
                    WHERE adminID='$id'
                    ";

            mysqli_query($conn,$sql);

            if(mysqli_affected_rows($conn)>0){
               return true;
            } 
        }

        public function getLastID() {
            global $conn;

            $sql = "SELECT MAX(adminID) AS adminID FROM admin;";
            $result = mysqli_query($conn, $sql);
            $record = mysqli_fetch_assoc($result);

            $admin_last_id = "A0000";
            if ($record["adminID"] !== NULL)
                $admin_last_id = $record["adminID"];

            $admin_last_id++;

            return $admin_last_id;
        }
    }
?>