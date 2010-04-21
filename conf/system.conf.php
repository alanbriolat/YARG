<?php
/**
 * YARG system configuration - you probably shouldn't touch this!
 */

$config['core']['library_paths'] = array('libraries');
$config['core']['module_paths'] = array('modules');
$config['autoload']['libraries'] = array(
    'xmlrpc',
    'csf_url_functions',
    'template_functions',
);
$config['autoload']['modules'] = array(
    'db',
    'template',
    'rtorrent',
);
$config['modules'] = array(
    'db' => array(
        'dsn' => 'sqlite:db.sqlite',
    ),
    'template' => array(
        'template_path' => 'tpl',
    ),
);
