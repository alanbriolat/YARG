<?php

error_reporting(E_ALL|E_NOTICE);

require_once 'csf/csf.php';
require_once 'conf/system.conf.php';
require_once 'conf/user.conf.php';

CSF::init($config);
$CSF = CSF();

$C = array();
$C['page'] = 'torrents';
$C['torrents'] = $CSF->rtorrent->get_torrents();
echo $CSF->template->render('torrentlist', $C);
