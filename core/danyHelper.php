<?php

    function _isEqual($val1, $val2) {
        if(trim($val1) == trim($val2)) { return true; }
        return false;
    }

    function _hasText($v) {
        if($v == null || trim($v) == "") { return false; }
        return true;
    }

    function _isInStr($str, $findWhat) {
		if(!_hasText($str) || !_hasText($findWhat)) { return false; }
		$pos = strpos($str, $findWhat);
		if($pos === false) { $pos = false; }
		return true;
    }

    function _getDoc($objectName) {
        global $doc;
        return $doc->get($objectName);
    }

    function setDanyUser(DanyUser $user) {
        if($user != null) {
            $_SESSION[ DANY_USER_VAR ] = serialize($user);
        }
    }

    function getDanyUser() {
        return unserialize($_SESSION[ DANY_USER_VAR ]);
    }
?>