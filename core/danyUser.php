<?php

    class DanyUser {
        public $id;
        public $userName;
        public $roleSet; // array olmali

        // ihtiyaciniz olan propertyleri ekleyin
        // usera ihtiyac duydugunuz yerde getDanyUser() ile
        // sessiondaki useri alabilirsiniz.

        public function hasRole($role) {
            if( in_array(trim($role), $this->roleSet) ) {
                return true;
            }
            return false;
        }
    }



?>