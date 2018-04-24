<?php
    namespace core;
    class UrlResolver {

        public $map;
        public $file = "system";        
        public $method = "notFound";
        public $httpMethod = "GET";
        public $granted;
        public $roles;
        public $requestedUrl;
        public $requestHttpMethod;
        public $controllerObject;
        private $controllerFullPath;
        public $mappedUrl;

        public function __construct() {
            $this->requestHttpMethod = $_SERVER['REQUEST_METHOD'];
            $this->requestedUrl = ($_GET['dany'] != null) ? $_GET['dany'] : '.' ;
            $this->resolveUrl();
        }

        public function resolveUrl() {
            $configuration = simplexml_load_file("config/route.xml");
            $entries = $configuration->map->item;
            foreach($entries as $e) {
                $mappedUrl = (String) $e->attributes()->name;
                if(fnmatch($mappedUrl, $this->requestedUrl)) {
                    $this->mappedUrl = $mappedUrl;
                    $this->file = (String) $e->attributes()->controller;
                    $this->method = (String) $e->attributes()->method;
                    $this->httpMethod = (String) $e->attributes()->httpMethod;
                    $this->granted = (String) $e->attributes()->granted;
                    $this->roles = (String) $e->attributes()->roles;
                    break;
                }
            }
        }
    }

/*
⠀⢠⡤⢺⣿⣿⣿⣿⣿⣶⣄
⠀⠀⠉⠀⠘⠛⠉⣽⣿⣿⣿⣿⡇
⠀⠀⠀⠀⠀⠀⠀⢉⣿⣿⣿⣿⡗
⠀⢀⣀⡀⢀⣀⣤⣤⣽⣿⣼⣿⢇⡄
⠀⠀⠙⠗⢸⣿⠁⠈⠋⢨⣏⡉⣳
⠀⠀⠀⠀⢸⣿⡄⢠⣴⣿⣿⣿
⠀⠀⠀⠀⠉⣻⣿⣿⣿⣿⣿⡟⡀
⠀⠀⠀⠀⠐⠘⣿⣶⡿⠟⠁⣴⣿⣄
⠀⠀⠀⠀⠀⠘⠛⠉⣠⣴⣾⣿⣿⣿⡦
⠀⠀⣴⣠⣄⠸⠿⣻⣿⣿⣿⣿⣿⣿⣿⣿⣿
*/
?>