<?php
    class Doc {
        private $row;
        private $configuration;

        public function Doc() {
            $this->configuration = simplexml_load_file("config/loader.xml");
            $this->init();
        }

        private function init() {
            $entries = $this->configuration->doc->item;
            if($entries != null && count($entries) > 0) {
                foreach($entries as $e) {
                    $arr = array();
                    $name = (String) $e->attributes()->name;
                    $item = new DocItem((String) $e->attributes()->path, 
                                            (String) $e->attributes()->object, 
                                                null, 
                                                    (String) $e->attributes()->namespace);
                    $this->row[ $name ] = $item;
                }
            }
            
        }

        // kopyasi, yenisi yada pointeri istenir mi acaba, dusunelim :)
        public function get($name) {
            if($this->row[ $name ] != null) {
                $this->create($name);
                $item = $this->getItem($name);
                return $item->object;
            } else {
                return null;
            }
        }

        private function getItem($name) {
            return $this->row[$name];
        }
        private function create($name) {
            $item = $this->getItem($name);
            if($item->object == null) {
                $path = $item->path;
                $objectName = $item->objectName;
                $obj = null;
                if(file_exists($path)) {
                    include_once($path);
                    if($item->namespace) {
                        $objectName = "\\" . $this->getValidNamespace($item->namespace) . "\\" . $objectName;
                    }
                    if(class_exists($objectName)) {    
                        $obj = new $objectName();
                    }
                }
                $item->object = $obj;
                $this->row[$name] = $item;
            }
        }

        private function getValidNameSpace($namespace) {
            $valid = str_replace(".", "\\", $namespace);
            return $valid;
        }
    }

    class DocItem {
        public $path;
        public $objectName;
        public $object;
        public $namespace;

        public function DocItem($path, $objectName, $object, $namespace) {
            $this->path = $path;
            $this->objectName = $objectName;
            $this->object = $object;
            $this->namespace = $namespace;
        }
    }
?>