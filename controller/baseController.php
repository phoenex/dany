<?php
    class BaseController {
        private $model;

        public function BaseController() {
            
        }

        protected function addToModel($key, $val) {
            $this->model[ $key ] = $val;
        }

        // ASAGIDAKI METHODLARI SILMEYIN!!!
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