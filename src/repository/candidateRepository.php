<?php 
    namespace repository;
    use util;

    Class candidateRepository {

        public function __construct() {
        }

        public function addCandidate(util\Candidate $candidate) {
            global $conn;

            $id = mysqli_real_escape_string($conn, $candidate->get_id());
            $username = mysqli_real_escape_string($conn, $candidate->get_username());
            $email = mysqli_real_escape_string($conn, $candidate->get_email());
            $password = mysqli_real_escape_string($conn, $candidate->get_password());


            $sql = "INSERT INTO candidate (candidateID, name, email, password)
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

        public function getCandidateByID($id) {
            global $conn;

            $candidate = null;
            $sql = "SELECT * FROM candidate WHERE candidateID = '$id'";

            $result = mysqli_query($conn,$sql);
            if($record = mysqli_fetch_assoc($result)) {
                $candidate = new util\Candidate($record['candidateID'], $record['name'], $record['email'], $record['password'], $record['disabled']);
            }
            
            return $candidate;
        }

        public function getCandidateByEmail($email) {
            global $conn;

            $candidate = null;
            $sql = "SELECT * FROM candidate WHERE email = '$email' AND disabled = 0";

            $result = mysqli_query($conn, $sql);
            if($record = mysqli_fetch_assoc($result)) {
                $candidate = new util\Candidate($record['candidateID'], $record['name'], $record['email'], $record['password'], $record['disabled']);
            }
            
            return $candidate;
        }

        public function getCandidateByNameAndEmail($name, $email) {
            global $conn;

            $candidate = null;
            $sql = "SELECT * FROM candidate WHERE name = '$name' AND email = '$email' AND disabled = 0";

            $result = mysqli_query($conn, $sql);
            if($record = mysqli_fetch_assoc($result)) {
                return $record['candidateID'];
            }
        }

        public function getAllCandidate() {
            global $conn;

            $candidateList = [];

            $sql = "SELECT * FROM candidate";

            $result = mysqli_query($conn,$sql);
            while($record = mysqli_fetch_assoc($result)) {
                $candidate = new util\Candidate($record['candidateID'], $record['name'], $record['email'], $record['password'], $record['disabled']);
                array_push($candidateList, $candidate);
            }

            return $candidateList;
        }

        public function updateCandidate(util\Candidate $candidate) {
            global $conn;

            $id = $candidate->get_id();
            $username = $candidate->get_username();
            $email = $candidate->get_email();
            $password = $candidate->get_password();
            $disabled = $candidate->is_disabled();

            $sql = "UPDATE candidate 
                    SET name = '$username',
                        email = '$email',
                        password = '$password',
                        disabled = '$disabled'
                    WHERE candidateID='$id'
                    ";

            mysqli_query($conn,$sql);

            if(mysqli_affected_rows($conn)>0){
               return true;
            } 
        }

        public function getLastID() {
            global $conn;

            $sql = "SELECT MAX(candidateID) AS candidateID FROM candidate;";
            $result = mysqli_query($conn, $sql);
            $record = mysqli_fetch_assoc($result);

            $candidate_last_id = "CA0000";
            if ($record["candidateID"] !== NULL)
                $candidate_last_id = $record["candidateID"];

            $candidate_last_id++;

            return $candidate_last_id;
        }
    }
?>