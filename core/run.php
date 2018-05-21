<?php
    /*
     *  Dany PHP v.1.0
     *  Cenk Atesdagli <phoenex@gmail.com>
     *  Mumkun oldugunca bu dosyayi bozmayin :P
     */
    include("core/danyHelper.php");
    include("core/doc.php");
    $doc = new Doc();
    
    $resolver = $doc->get("resolver");
    // controllerdan onceki son cikis :)
    // url kaydi belli artik, sayfa koruma yapilacaksa burada
    // araya girilebilir.

    // config onemli :)
    $config = $doc->get("config");
    define("DANY_ENV", $config->getEnvironment());
    define("PROJECT_URL", $config->projectUrl);
    // controller calistiriliyor
    $controller = $doc->get("controller");
    $controller->process( $resolver, $config->controllerScanPath );
    unset($resolver);
    unset($config);
    
    if($controller->hasError) {
        // burada hatayi handle edebilirsiniz
        // hata $controller'in error propertylerine set edilmistir.
        $view= "system/error";
    } else {
        $view = $controller->view;
        if(!file_exists("view/" . $view . ".php")) {
            $controller->hasError = true;
            $controller->errorCode = 500;
            $controller->errorMessage = "view file does not exists! : view/" . $view . ".php";
            $view= "system/error";
        }
    }
    $danyLayout = getLayout();
    unset($controller);
    unset($doc);

    $danyView = "view/" . $view . ".php";
    include("view/layout/" . $danyLayout . ".php");
?>