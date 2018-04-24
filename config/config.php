<?php
    namespace config;
    class Config {
        private $servers;
        private $mode;
        public $dbConfig;
        public $projectUrl;
        public $controllerScanPath;

        public function __construct() {
            $this->controllerScanPath = "controller";
            $this->servers = array("http://localhost/dany/dany/", "http://" . $_SERVER['HTTP_HOST'] . "/");
            $this->mode = array("dev", "prod");
        }

        public function getEnvironment() {
            $len = count($this->servers);
            for($a = 0; $a < $len; $a++) {
                if(_isInStr($_SERVER['SERVER_NAME'], $this->servers[$a]) || _isInStr($this->servers[$a], $_SERVER['SERVER_NAME'])) {
                    $this->projectUrl = $this->servers[$a];
                    return $this->mode[$a];
                }
            }
        }
    }
?>