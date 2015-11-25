<?php

$routes[] = ['GET|POST', '/admin/ogone/form', 'GoCart\Controller\AdminOgone#form'];
$routes[] = ['GET|POST', '/admin/ogone/install', 'GoCart\Controller\AdminOgone#install'];
$routes[] = ['GET|POST', '/admin/ogone/uninstall', 'GoCart\Controller\AdminOgone#uninstall'];
$routes[] = ['GET|POST', '/ogone/process-payment', 'GoCart\Controller\Ogone#processPayment'];

$paymentModules[] = ['name'=>'Ingenico Payment Services', 'key'=>'ogone', 'class'=>'Ogone'];