<?php
    class HomeController extends BaseController {
        
        public function welcome() {
            $this->addToModel("isim", "dany");
            return "home";
        }

    }
?>