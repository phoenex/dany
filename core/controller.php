<?php 
    namespace core;

    class Controller {

        private $file;
        private $object; // controller objesinin adi
        private $method;
        public $hasError = false;
        public $errorCode;
        public $errorMessage;
        private $controllerObject; // controller objesi
        public $view;

        public function process( UrlResolver $resolver, $controllerScanPath) {
            $this->file = $controllerScanPath . "/" . lcfirst($resolver->file) . "Controller.php";
            $this->object = ucfirst($resolver->file) . "Controller";
            $this->method = $resolver->method;

            if(!_isEqual(strtolower($resolver->httpMethod), strtolower($resolver->requestHttpMethod))) {
                $this->hasError = true;
                $this->errorCode = 405;
                $this->errorMessage = "Invalid http method!";
            } else if(!file_exists($this->file)) {
                $this->hasError = true;
                $this->errorCode = 500;
                $this->errorMessage = "Controller file not found!";
            } else if(!$this->hasPermission($resolver)) {
                $this->hasError = true;
                $this->errorCode = 401;
                $this->errorMessage = "Not authorized!";
            } else {
                include($controllerScanPath . "/baseController.php");
                include($this->file);
                $objectName = $this->object;
                $methodName = $this->method;
                if(!class_exists($this->object) || !method_exists($this->object, $this->method)) {
                    $this->hasError = true;
                    $this->controllerObject = new $objectName();
                    $this->errorCode = 500;
                    $this->errorMessage = "Controller object or controller method not found! : " . $this->object . " - " . $this->method;
                } else {
                    $this->controllerObject = new $objectName();
                    $this->view = call_user_func_array(array($this->controllerObject, $methodName), $this->getParams($resolver));
                }
                $this->_setVarsToGlobal();
            }
        }

        private function hasPermission(UrlResolver $resolver) {

            // url bir rolle korunmuyorsa yetki var
            if(empty($resolver->roles)) {
                return true;
            }
            // Bu noktada anliyoruz ki url bir rolle korunuyor, bunun icin bize
            // bir user gerek, eger user null ise yetkisizdir
            $user = getDanyUser();
            if($user == null) return false;

            // url rolle korunuyor ve user null degil. Oyle ise
            // kullanicinin yetkisi var mi bakalim
            $roles = explode(",", $resolver->roles);
            if($resolver->granted == "any") {
                // user belirtilen rollerden herhangibirine sahip olsa yeter
                foreach ($roles as $role) {
                    if($user->hasRole($role)) {
                        return true;
                    }
                }
                return false;
            } else {
                // user belirtilen rollerin tamamina sahip olmak zorunda
                foreach ($roles as $role) {
                    if(!$user->hasRole($role)) {
                        return false;
                    }
                }
                return true;
            }
        }

        private function getParams($resolver) {
            $name = str_replace("*", "", $resolver->mappedUrl);
            $url = str_replace($name,"",$_GET['dany']);
            echo $this->mappedUrl;
			return explode("/", $url);			
        }
        
        private function _setVarsToGlobal() {
            // model verileri global erişime set ediliyor
            $_model = getModel();
			if($_model != null) {
				$keyArray = array_keys($_model);
				for($a = 0; $a < count($keyArray); $a++) {
                    $key = $keyArray[$a];
					$GLOBALS[ $key ] = $_model[ $key ];
				}
				// info ve hata mesajlarini ekle
				$GLOBALS["_infoList"] = $_SESSION['_vInfoList'];
				$GLOBALS["_errorList"] = $_SESSION['_vErrorList'];
				unset($this->_model);
			}
        }

    }
?>