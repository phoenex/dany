<?php
    class Doc {
        private $row;
        private $dependencyItemList;
        private $configuration;

        public function Doc() {
            $this->configuration = simplexml_load_file("config/loader.xml");
            $this->init();
        }

        private function init() {
            $entries = $this->configuration->doc->item;
            if($entries != null && count($entries) > 0) {
                foreach($entries as $e) {
                    $name = (String) $e->attributes()->name;
                    $item = new DocItem((String) $e->attributes()->path, 
                                            (String) $e->attributes()->object, 
                                                null, 
                                                    (String) $e->attributes()->namespace,
                                                        (String) $e->attributes()->dependency);
                    $this->row[ $name ] = $item;
                }
            }
            
            $dependencies = $this->configuration->dependency->item;
            if(!empty($dependencies)) {
                foreach($dependencies as $dep) {
                    $name = (String) $dep->attributes()->name;
                    $item = new DocItem((String) $dep->attributes()->path, null, null, null, null); 
                    $this->dependencyItemList[ $name ] = $item;
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
                    // bu classin calisabilmesi icin baska class dosyalarina ihtiyac varsa
                    // baska classlari extend yada implement ediyorsa include etmeli
                    if(_hasText($item->dependency)) {
                        $dependencyList = $this->getDependenctItemList($item->dependency);
                        if($dependencyList != null) {
                            foreach($dependencyList as $depItem) {
                                if(file_exists($depItem->path)) {
                                    require_once($depItem->path);
                                }
                            }
                        }
                    }
                    require_once($path);
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

        private function getDependenctItemList($dependency) {
            $exp = explode(",", $dependency);
            $list = null;
            foreach($exp as $d) {
                $name = trim($d);
                if($this->dependencyItemList[ $name ] != null) {
                    $list[] = $this->dependencyItemList[ $name ];
                }
            }
            return $list;
        }
    }

    class DocItem {
        public $path;
        public $objectName;
        public $object;
        public $namespace;
        public $dependency;

        public function DocItem($path, $objectName, $object, $namespace, $dependency) {
            $this->path = $path;
            $this->objectName = $objectName;
            $this->object = $object;
            $this->namespace = $namespace;
            $this->dependency = $dependency;
        }
    }
?>