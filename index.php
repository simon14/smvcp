<?php

//
// PHASE: BOOTSTRAP
//
define('SMVC_INSTALL_PATH', dirname(__FILE__));
define('SMVC_SITE_PATH', SMVC_INSTALL_PATH . '/site');

require(SMVC_INSTALL_PATH.'/src/bootstrap.php');

$cs = CSmvc::Instance();

//
// PHASE: FRONTCONTROLLER ROUTE
//
$cs->FrontControllerRoute();
//
// PHASE: THEME ENGINE RENDER
//
$cs->ThemeEngineRender();

?>