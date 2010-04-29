<?php

header('Content-Type: text/css');

require_once 'csf/csf.php';
CSF::add_library_path('extlib');
CSF::load_library('lessphp/lessc.inc');

$whitelist = array('style.less');

$infile = $_SERVER['QUERY_STRING'];
if (!in_array($infile, $whitelist)) exit();

$lc = new lessc($infile);
echo $lc->parse();
