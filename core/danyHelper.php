<?php
    // buna dokunmuyoruz :P
    $_model = null;
    $_layout = "mainLayout";

    function getModel() {
        global $_model;
        return $_model;
    }

    function addToModel($key, $val) {
        global $_model;
        $_model[ $key ] = $val;
    }

    function setLayout($layout){
        if(file_exists("view/layout/" . $layout . ".php")) {
            global $_layout;
            $_layout = $layout;
        }
    }

    function getLayout() {
        global $_layout;
        return $_layout;
    }

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

    function addToInfo($message) {
        $info = $_SESSION['_danyInfo'];
        $info[] = $message;
        $_SESSION['_danyInfo'] = $info;
    }

    function addToError($message) {
        $error = $_SESSION['_danyError'];
        $error[] = $message;
        $_SESSION['_danyError'] = $error;
    }

    function getErrors($seperator = null) {
        if($seperator == null) return $_SESSION['_danyError'];
        return implode($seperator, $_SESSION['_danyError']);
    }

    function getInfos($seperator = null) {
        if($seperator == null) return $_SESSION['_danyInfo'];
        return implode($seperator, $_SESSION['_danyInfo']);
    }

    function getPrettyUrl($val) {
    	$dizi = array("ı" => "i", "ü" => "u", "ş" => "s", "ç" => "c", 
    					"ö" => "o", "ğ" => "g", "İ" => "I", "Ü" => "U", 
    					"Ş" => "S", "Ç" => "C", "Ö" => "O", "Ğ" => "G", " " => "-");
    	$val = strtr($val, $dizi);
    	return preg_replace('#[^A-Za-z0-9_-]#','',strtolower($val));
    }

    function redirectView($url) {
        header("location:" . $url);
        exit;
    }
?>