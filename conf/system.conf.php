<?php
/**
 * YARG system configuration - you probably shouldn't touch this!
 */

$config['core']['library_paths'] = array('libraries');
$config['core']['module_paths'] = array('modules');

$config['autoload']['libraries'] = array(
    'xmlrpc',
    'csf_url_functions',
    'util_functions',
    'template_functions',
    'csf_controller',
    'controller',
);

$config['autoload']['modules'] = array(
    'db',
    'template',
    'dispatch',
    'request',
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

$config['modules']['dispatch'] = array(
    'case_sensitive' => true,
    'controller_path' => 'controllers',
    'routes' => array(
        'list' => array('controller' => 'torrents', 'rewrite' => 'torrent_list'),
        '^$' => array('controller' => 'torrents', 'rewrite' => 'torrent_list/default'),
    ),
);
