<?php
    class Doc {
        private $row;
        private $configuration;

        public function Doc() {
            $this->configuration = simplexml_load_file("dapp/loader.xml");
            $this->init();
        }

        private function init() {
            $entries = $this->configuration->doc->item;
            if($entries != null && count($entries) > 0) {
                foreach($entries as $e) {
                    $arr = array();
                    $name = (String) $e->attributes()->name;
                    $arr['path'] = (String) $e->attributes()->path;
                    $arr['objectName'] = (String) $e->attributes()->object;
                    $arr['object'] = null;
                    $this->row[ $name ] = $arr;
                }
            }
        }

        // kopyasi, yenisi yada pointeri istenir mi acaba, dusunelim :)
        public function get($name) {
            if($this->row[ $name ] != null) {
                $this->create($name);
                return $this->row[ $name ]['object'];
            } else {
                return null;
            }
        }

        private function create($name) {
            if($this->row[$name]['object'] == null) {
                $path = $this->row[$name]['path'];
                $objectName = $this->row[$name]['objectName'];
                $obj = null;
                if(file_exists($path)) {
                    include_once($path);
                    if(class_exists($objectName)) { 
                        $obj = new $objectName();
                    }
                }
                $this->row[$name]['object'] = $obj;
            }
        }
    }
?>