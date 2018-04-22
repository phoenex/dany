<?php
    session_start();
    date_default_timezone_set("Europe/Istanbul");
    include("core/danyHelper.php");
    include("core/doc.php");
    $doc = new Doc();
    $config = $doc->get("config");
    $resolver = $doc->get("resolver");
    $controller = $doc->get("controller");
    $controller->process( $resolver, $config->controllerScanPath );

    if($controller->hasError) {
        // burada hatayi handle edebilirsiniz
        // hata $controller'in error propertylerine set edilmistir.
        $view= "system/error";
    } else {
        $view = $controller->view;
    }

    $danyView = $config->viewPath . "/" . $view . ".php";
    include($config->viewPath . "/layout/mainLayout.php");
?>