<?php
    class HomeController extends BaseController {
        
        public function welcome() {
            addToModel("message", "Deneyseldir, çokta şeyetmeyin yani :)");
            return "home";
        }

        public function version() {
            addToModel("versionNum", "1.0");
            addToModel("versionLabel", "otizm");
            return "version";
        }

        public function paramSample($param1, $param2) {
            addToModel("param1", $param1);
            addToModel("param2", $param2);
            return "param";
        }
    }
?>