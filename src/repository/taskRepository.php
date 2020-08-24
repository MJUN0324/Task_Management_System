<?php 
     namespace repository;
     use util;

    class taskRepository {
        
        public function __construct() {
        }

        public function addtask(util\Task $task) {
            global $conn;

            $id = $task->get_task_id();
            $name = $task->get_task_name();
            $companyID = $task->get_company_id();
            $start = $task->get_start();
            $end = $task->get_end();
            $attemptTime = $task->get_attempt_time();
            $attemptLimit = $task->get_attempt_limit();
            $description = $task->get_description();
            $question = $task->get_question();

            $sql = "INSERT INTO task(taskID, taskName, companyID, start, end, attemptTime, attemptLimit, description, question) 
                    VALUES(
                        '{$id}',
                        '{$name}',
                        '{$companyID}',
                        '{$start}',
                        '{$end}',
                        '{$attemptTime}',
                        '{$attemptLimit}',
                        '{$description}',
                        '{$question}'
                    )";

            mysqli_query($conn,$sql);

            if(mysqli_affected_rows($conn)>0){
               return true;
            } 
        }

        public function addFile($taskID, $no, util\File $file) {
            global $conn;

            $fileName = $file->get_file_name();
            $fileLocation = $file->get_file_location();

            $sql = "INSERT INTO task_file(taskID, fileNo, fileName, fileLocation) 
                        VALUES(
                            '{$taskID}',
                            '{$no}',
                            '{$fileName}',
                            '{$fileLocation}'   
                        )";

            mysqli_query($conn,$sql);

            if(mysqli_affected_rows($conn)>0){
                return true;
            }
        }

        public function addCandidateToTask($taskID, $candidateID) {
            global $conn;
            
            $sql = "INSERT INTO candidate_task(taskID, candidateID)
                        VALUES (
                            '{$taskID}',
                            '{$candidateID}'
                        )";
            
            mysqli_query($conn,$sql);

            if(mysqli_affected_rows($conn)>0){
                return true;
            } 
        }

        public function getTaskByID($id) {
            global $conn;

            $task = null;
            $sql = "SELECT * FROM task WHERE taskID = '$id'";

            $result = mysqli_query($conn,$sql);
            if($record = mysqli_fetch_assoc($result)) {
                $task = new util\Task($record['taskID'], $record['taskName'], $record['companyID'], $record['start'], $record['end'], $record['attemptTime'], $record['attemptLimit'], $record['description'], $record['question'], $record['disabled']);
                $task->set_file_list(self::getFileListByTaskID($record['taskID']));
                $task->set_candidate_list(self::getCandidateListByTaskID($record['taskID']));
                $task->set_disabled($record['disabled']);
            }
            
            return $task;
        }

        public function getTaskByCompanyID($companyID) {
            global $conn;

            $taskList = [];

            $sql = "SELECT * FROM task WHERE companyID = '$companyID'";

            $result = mysqli_query($conn,$sql);
            while($record = mysqli_fetch_assoc($result)) {
                $task = new util\Task($record['taskID'], $record['taskName'], $record['companyID'], $record['start'], $record['end'], $record['attemptTime'], $record['attemptLimit'], $record['description'], $record['question'], $record['disabled']);
                $task->set_file_list(self::getFileListByTaskID($record['taskID']));
                $task->set_candidate_list(self::getCandidateListByTaskID($record['taskID']));
                $task->set_disabled($record['disabled']);
                array_push($taskList, $task);
            }

            return $taskList;
        }

        public function getFileListByTaskID($id) {
            global $conn;

            $fileList = [];

            $sql = "SELECT * FROM task_file WHERE taskID = '$id'";

            $result = mysqli_query($conn,$sql);
            while($record = mysqli_fetch_assoc($result)) {
                $file = new util\File($record['fileName'], $record['fileLocation']);
                array_push($fileList, $file);
            }

            return $fileList;
        }

        public function getTaskByCandidateID($candidateID) {
            global $conn;

            $taskList = [];

            $sql = "SELECT * FROM candidate_task, task WHERE candidate_task.taskID = task.taskID AND candidateID = '$candidateID' ORDER BY start DESC";

            $result = mysqli_query($conn,$sql);
            while($record = mysqli_fetch_assoc($result)) {
                $task = new util\Task($record['taskID'], $record['taskName'], $record['companyID'], $record['start'], $record['end'], $record['attemptTime'], $record['attemptLimit'], $record['description'], $record['question'], $record['disabled']);
                $task->set_file_list(self::getFileListByTaskID($record['taskID']));
                //$task->set_candidate_list(self::getCandidateListByTaskID($record['taskID']));
                array_push($taskList, $task);
            }

            return $taskList;
        }

        public function getCandidateListByTaskID($id) {
            global $conn;

            $candidateList = [];

            $sql = "SELECT * FROM candidate, candidate_task WHERE candidate_task.candidateID = candidate.candidateID AND candidate_task.taskID = '$id'";

            $result = mysqli_query($conn,$sql);

            while($record = mysqli_fetch_assoc($result)) {
                $candidate = new util\Candidate($record['candidateID'], $record['name'], $record['email'], $record['password'], $record['disabled']);
                array_push($candidateList, $candidate);
            }

            return $candidateList;
        } 

        public function getCandidateListNotInTask($taskID) {
            global $conn;

            $candidateList = [];

            $sql = "SELECT *
                    FROM candidate
                    WHERE candidateID NOT IN (
                        SELECT candidateID 
                        FROM candidate_task 
                        WHERE taskID = '$taskID'
                    )
                    ";

            $result = mysqli_query($conn,$sql);

            while($record = mysqli_fetch_assoc($result)) {
                $candidate = new util\Candidate($record['candidateID'], $record['name'], $record['email'], $record['password'], $record['disabled']);
                array_push($candidateList, $candidate);
            }

            return $candidateList;
        }

        public function updateTask(util\Task $task) {
            global $conn;

            $id = $task->get_task_id();
            $name = $task->get_task_name();
            $start = $task->get_start();
            $end = $task->get_end();
            $attemptTime = $task->get_attempt_time();
            $attemptLimit = $task->get_attempt_limit();
            $description = $task->get_description();
            $question = $task->get_question();

            $sql = "UPDATE task 
                    SET taskName = '{$name}',
                        start = '{$start}',
                        end = '{$end}',
                        attemptTime = '{$attemptTime}',  
                        attemptLimit = '{$attemptLimit}',  
                        description = '{$description}',
                        question = '{$question}'
                    WHERE taskID = '{$id}';
                    ";

            mysqli_query($conn,$sql);

            if(mysqli_affected_rows($conn)>0){
                return true;
            } 
        }

        public function disableTask($id) {
            global $conn;
            
            $sql = "UPDATE task 
                    SET disabled = true
                    WHERE taskID = '$id';
                    ";

            mysqli_query($conn,$sql);

            if(mysqli_affected_rows($conn)>0){
               return true;
            } 
        }

        public function enableTask($id) {
            global $conn;
            
            $sql = "UPDATE task 
                    SET disabled = false
                    WHERE taskID = '$id';
                    ";

            mysqli_query($conn,$sql);

            if(mysqli_affected_rows($conn)>0){
               return true;
            } 
        }

        public function getLastID() {
            global $conn;

            $sql = "SELECT MAX(taskID) AS taskID FROM task;";
            $result = mysqli_query($conn, $sql);
            $record = mysqli_fetch_assoc($result);

            $task_last_id = "T0000";
            if ($record["taskID"] !== NULL)
                $task_last_id = $record["taskID"];

            $task_last_id++;

            return $task_last_id;
        }

        public function startTask($taskID, $candidateID, $attemptTime) {
            global $conn;

            date_default_timezone_set('Asia/Hong_Kong');
            $startTime = new \DateTime();
            $endTime = clone $startTime;

            $timeArr = array_map('intval', explode(':', $attemptTime));
            $intervalStr = 'PT' . $timeArr[0] . 'H' . $timeArr[1] . 'M' . $timeArr[2] . 'S'; 

            $endTime -> add(new \DateInterval($intervalStr));

            $sql = "UPDATE candidate_task 
                    SET startTime = '{$startTime->format('Y-m-d H:i:s')}',
                        endTime = '{$endTime->format('Y-m-d H:i:s')}'
                    WHERE taskID = '$taskID' AND
                        candidateID = '$candidateID'
                    ";

            $result = mysqli_query($conn, $sql);

            if (mysqli_num_rows($result) > 0) {
            }

            $sql = "INSERT INTO result (taskID, candidateID, answer, status) 
                    VALUES ('$taskID',
                            '$candidateID',
                            '', 
                            'unsubmit'
                    )";

            $result = mysqli_query($conn, $sql);

            if (mysqli_num_rows($result) > 0) {
                return true;
            }               
        }

        public function isStarted($taskID, $candidateID) {
            global $conn;

            $sql = "SELECT * FROM result WHERE taskID = '$taskID' AND candidateID = '$candidateID';";
            $result = mysqli_query($conn, $sql);

            if (mysqli_num_rows($result) > 0) {
                return true;
            }
        }

        public function saveAnswer($taskID, $candidateID, $answer) {
            global $conn;

            $sql = "UPDATE result 
                    SET answer = '$answer'
                    WHERE taskID = '$taskID' AND
                          candidateID = '$candidateID'
                    ";

            $result = mysqli_query($conn, $sql);

            if(mysqli_affected_rows($conn)>0){
                return true;
            } 
        }

        public function getAnswer($taskID, $candidateID) {
            global $conn;

            $sql = "SELECT answer 
                    FROM result
                    WHERE taskID = '$taskID' AND
                          candidateID = '$candidateID'
                    ";

            $result = mysqli_query($conn, $sql);
            $record = mysqli_fetch_assoc($result);

            return $record['answer'];
        }

        public function submit($taskID, $candidateID, $answer) {
            global $conn;

            $sql = "UPDATE result 
                    SET answer = '$answer',
                        status = 'submitted'
                    WHERE taskID = '$taskID' AND
                          candidateID = '$candidateID'
                    ";

            $result = mysqli_query($conn, $sql);

            if(mysqli_affected_rows($conn)>0){
                return true;
            } 
        }

        public function unsubmit($taskID, $candidateID) {
            global $conn;

            $sql = "UPDATE result 
                    SET status = 'unsubmit'
                    WHERE taskID = '$taskID' AND
                          candidateID = '$candidateID'
                    ";

            $result = mysqli_query($conn, $sql);

            if(mysqli_affected_rows($conn)>0){
                return true;
            } 
        }

        public function removeCandidate($taskID, $candidateID) {
            global $conn;

            $sql = "DELETE FROM candidate_task 
                    WHERE taskID = '$taskID' AND
                          candidateID = '$candidateID'
                    ";           

            $result = mysqli_query($conn, $sql);

            if(mysqli_affected_rows($conn)>0){
                $sql = "SELECT * 
                        FROM result
                        WHERE taskID = '$taskID' AND
                              candidateID = '$candidateID'
                        ";  
                $result = mysqli_query($conn, $sql);

                if(mysqli_num_rows($result) > 0) {
                    $sql = "DELETE FROM result 
                        WHERE taskID = '$taskID' AND
                            candidateID = '$candidateID'
                        ";  

                    $result = mysqli_query($conn, $sql);

                    if(mysqli_affected_rows($conn)>0){
                        return true;
                    }
                }
                else {
                    return true;
                }     
            } 
        }

        public function getCandidateStartAndEndTime($taskID, $candidateID) {
            global $conn;

            $sql = "SELECT startTime, endTime
                    FROM candidate_task 
                    WHERE taskID = '$taskID' AND 
                          candidateID = '$candidateID'
                    ";

            $result = mysqli_query($conn, $sql);
            $record = mysqli_fetch_assoc($result);

            return array($record['startTime'], $record['endTime']);
        }

        public function getStatus($taskID, $candidateID) {
            global $conn;

            $sql = "SELECT status 
                    FROM result
                    WHERE taskID = '$taskID' AND
                          candidateID = '$candidateID'
                    ";

            $result = mysqli_query($conn, $sql);
            $record = mysqli_fetch_assoc($result);

            return $record['status'];
        }

        public function getResult($taskID, $candidateID) {
            global $conn;

            $sql = "SELECT *
                    FROM result 
                    WHERE taskID = '$taskID' AND 
                          candidateID = '$candidateID'
                    ";

            $result = mysqli_query($conn, $sql);
            if($record = mysqli_fetch_assoc($result)) {
                $result = new util\Result($record['taskID'], $record['candidateID'], $record['answer'], $record['status'], $record['marks'], $record['grade'], $record['comment']);
            }

            return $result;
        }

        //new
        public function getResultList($taskID){
            global $conn;

            $resultList = [];

            $sql = "SELECT *
                    FROM result
                    WHERE taskID = '$taskID' AND status = 'marked'
                    ";

            $result = mysqli_query($conn, $sql);

            while($record = mysqli_fetch_assoc($result)) {
                $result = new util\Result($record['taskID'], $record['candidateID'], $record['answer'], $record['status'], $record['marks'], $record['grade'], $record['comment']);
                array_push($resultList, $result);
            }
            return $resultList;
        }

        public function markResult($taskID, $candidateID, $marks, $grade, $comment) {
            global $conn;

            $sql = "UPDATE result 
                    SET status = 'marked',
                        marks = '{$marks}',
                        grade = '{$grade}',  
                        comment = '{$comment}'
                    WHERE taskID = '{$taskID}' AND candidateID = '{$candidateID}';
                    ";

            mysqli_query($conn,$sql);

            if(mysqli_affected_rows($conn)>0){
                return true;
            } 
        }

        public function getSubmitResultList($taskID){
            global $conn;

            $resultList = [];

            $sql = "SELECT *
                    FROM result
                    WHERE taskID = '$taskID' AND
                        (status = 'submitted' OR status = 'marked')
                    ";

            $result = mysqli_query($conn, $sql);
            print_r($result);

            while($record = mysqli_fetch_assoc($result)) {
                $result = new util\Result($record['taskID'], $record['candidateID'], $record['answer'], $record['status'], $record['marks'], $record['grade'], $record['comment']);
                array_push($resultList, $result);
            }

            return $resultList;
        }
        //
    }
?>