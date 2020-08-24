<?php
    namespace util;

    class File {
        private $fileName;
        private $fileLocation;

        public function __construct($fileName, $fileLocation) {
            $this->set_file_name($fileName);
            $this->set_file_location($fileLocation);
        }

        public function get_file_name() {
            return $this->fileName;
        }
    
        public function set_file_name($fileName) {
            $this->fileName = $fileName;
        }

        public function get_file_location() {
            return $this->fileLocation;
        }
    
        public function set_file_location($fileLocation) {
            $this->fileLocation = $fileLocation;
        }
    }
?>