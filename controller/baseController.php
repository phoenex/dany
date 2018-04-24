<?php
    class BaseController {
        private $model;
        private $layout = "mainLayout";

        public function BaseController() {
            
        }

        
        // ---
        protected function addToModel($key, $val) {
            $this->model[ $key ] = $val;
        }
        
        protected function setLayout($layout){
            if(file_exists("view/layout/" . $layout . ".php")) {
                $this->layout = $layout;
            }
        }

        public function getLayout() {
            return $this->layout;
        }

        protected function addToInfo($message) {
            $info = $_SESSION['_danyInfo'];
            $info[] = $message;
            $_SESSION['_danyInfo'] = $info;
        }

        protected function addToError($message) {
            $error = $_SESSION['_danyError'];
            $error[] = $message;
            $_SESSION['_danyError'] = $error;
        }

        public function getModel() {
            return $this->model;
        }
    }
?>