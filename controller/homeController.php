<?php
    class HomeController extends BaseController {
        
        public function welcome() {
            $this->addToModel("isim", "dany");
            return "home";
        }

        public function version() {
            $this->addToModel("versionNum", "1.0");
            $this->addToModel("versionLabel", "otizm");
            return "version";
        }

        public function paramSample($param1, $param2) {
            $this->addToModel("param1", $param1);
            $this->addToModel("param2", $param2);
            return "param";
        }
    }
?>