<?php 
    namespace controller;
    use repository, util;

    if(!isset($_SESSION)) { 
        session_start(); 
    } 

    Class taskController {
       private $repository;

        public function __construct() {
            $this->repository = new repository\taskRepository();
        }

        public function addTask($taskName, $companyID, $start, $end, $attemptTime, $attempLimit, $description, $question) {
            // Add Task
            $id = $this->repository->getLastID();
            
            $task = new util\Task($id, $taskName, $companyID, $start, $end, $attemptTime, $attempLimit, $description, $question);
            $success = $this->repository->addTask($task);

            //Add Task File     
            mkdir("../../assets/question/" . $id);
            

            if($success) {
                $_SESSION['Msg'] = "Task created";
                return $id;
            }
            else {  
                $_SESSION['Error Msg'] = "Error occured while creating task";
            }
        }

        public function addFile($taskID, $no, $fileName, $fileLocation) {
            $file = new util\File($fileName, $fileLocation);
            $success = $this->repository->addFile($taskID, $no, $file);
            if($success) {
                return true;
            }
            else {  
                return false;
            }
        }
        
        public function addCandidateToTask($taskID, $candidateID) {
            $success = $this->repository->addCandidateToTask($taskID, $candidateID);

            if ($success) {
                $_SESSION["Msg"] = "Candidate assigned.";
            } 
            else {
                $_SESSION["Error Msg"] = "Error: Candidate cannot be assigned.";
            }
        }

        public function getTaskByID($id){
            $task = $this->repository->getTaskByID($id);
            return $task;
        }

        public function getTaskListByCompanyID($companyID){
            $taskList = $this->repository->getTaskByCompanyID($companyID);
            return $taskList;
        }

        public function getTaskByCandidateID($candidateID) {
            $taskList = $this->repository->getTaskByCandidateID($candidateID);
            return $taskList;
        }

        public function getCandidateListNotInTask($taskID) {
            $candidateList = $this->repository->getCandidateListNotInTask($taskID);
            return $candidateList;
        }

        public function edit($taskID, $taskName, $companyID, $start, $end, $attemptTime, $attempLimit, $description, $question) {
            $task = new util\Task($taskID, $taskName, $companyID, $start, $end, $attemptTime, $attempLimit, $description, $question);
            $success = $this->repository->updateTask($task);

            if($success) {
                $_SESSION['Msg'] = "Task updated";
            }
            else {  
                $_SESSION['Error Msg'] = "Error occured while updating task";
            }
        }

        public function delete($id) {
            $success = $this->repository->disableTask($id);

            if($success) {
                header("Location:http://". $_SERVER['HTTP_HOST'] . "/public/company/task_panel.php?id=" . $id);
            }
        }

        public function recover($id) {
            $success = $this->repository->enableTask($id);

            if($success) {
                header("Location:http://". $_SERVER['HTTP_HOST'] . "/public/company/task_panel.php?id=" . $id);
            }
        }

        public function startTask($taskID, $candidateID, $attemptTime) {
            $success = $this->repository->startTask($taskID, $candidateID, $attemptTime);

            if($success) {
                header("Location:task.php?id=" . $taskID);
            }
        }

        public function isStarted($taskID, $candidateID) {
            $isStarted = $this->repository->isStarted($taskID, $candidateID);

            if($isStarted) {
                header("Location:task.php?id=" . $taskID);
            }
        }

        public function saveAnswer($taskID, $candidateID, $answer) {
            $success = $this->repository->saveAnswer($taskID, $candidateID, $answer);

            return $success;
        }

        public function getAnswer($taskID, $candidateID) {
            $answer = $this->repository->getAnswer($taskID, $candidateID);
            
            return $answer;
        }

        public function submit($taskID, $candidateID, $answer) {
            $success = $this->repository->submit($taskID, $candidateID, $answer);

            return $success;
        }

        public function unsubmit($taskID, $candidateID) {
            $success = $this->repository->unsubmit($taskID, $candidateID);

            if($success) {
                header("Location:http://". $_SERVER['HTTP_HOST'] . "/public/company/task_panel.php?id=" . $taskID);
            }
        }

        public function removeCandidate($taskID, $candidateID) {
            $success = $this->repository->removeCandidate($taskID, $candidateID);

            if($success) {
                header("Location:http://". $_SERVER['HTTP_HOST'] . "/public/company/task_panel.php?id=" . $taskID);
            }
        }

        public function getStatus($taskID, $candidateID) {
            $status = $this->repository->getStatus($taskID, $candidateID);

            return $status;
        }

        public function getCandidateStartAndEndTime($taskID, $candidateID) {
            $result = $this->repository->getCandidateStartAndEndTime($taskID, $candidateID);
            
            return $result;
        }

        public function getResult($taskID, $candidateID) {
            $result = $this->repository->getResult($taskID, $candidateID);
            
            return $result;
        }

        //new
        //for statistic
        public function getResultList($taskID) {
            $resultList = $this->repository->getResultList($taskID);

            return $resultList;
        }

        public function markResult($taskID, $candidateID, $marks, $grade, $comment) {
            $success = $this->repository->markResult($taskID, $candidateID, $marks, $grade, $comment);
            
            return $success;
        }

        //for plagiarism in task.php
        public function getSubmitResultList($taskID) {
            $resultList = $this->repository->getSubmitResultList($taskID);

            return $resultList;
        }
        //
    }
?>