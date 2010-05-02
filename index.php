<?php

define('YARG_NAME', 'YARG');
define('YARG_VERSION', '0.1');
define('YARG_URL', 'http://github.com/alanbriolat/YARG');

error_reporting(E_ALL|E_NOTICE);

require_once 'csf/csf.php';
require_once 'conf/system.conf.php';
require_once 'conf/user.conf.php';

CSF::init($config);
$CSF = CSF();

$response = $CSF->dispatch->dispatch_uri($CSF->request->get_uri());
echo $response;
