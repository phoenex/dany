<?php
    class Config {
        private $servers;
        private $mode;
        public $dbConfig;
        public $projectUrl;
        public $viewPath;
        public $controllerScanPath;

        public function Config() {
            $this->controllerScanPath = "dapp/controller";
            $this->viewPath = "dapp/view";
            $this->servers = array("http://localhost/dany/", "http://" . $_SERVER['HTTP_HOST'] . "/");
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