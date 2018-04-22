<?php
    /*
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
    }
    unset($controller);
    unset($doc);
    $danyView = "dapp/view/" . $view . ".php";
    include("dapp/view/layout/mainLayout.php");
?>