<?php

error_reporting(E_ALL|E_NOTICE);

require_once 'csf/csf.php';
require_once 'conf/system.conf.php';
require_once 'conf/user.conf.php';

CSF::init($config);
$CSF = CSF();

$response = $CSF->dispatch->dispatch_uri($CSF->request->get_uri());
echo $response;
