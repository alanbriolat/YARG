<?php
/**
 * YARG user configuration
 */

// URL to the YARG installation
$config['url_functions']['base_url'] = 'http://example.com/';
// SSL URL (optional - will automatically use HTTPS of base_url)
//$config['url_functions']['secure_base_url'] = 'https://example.com/'

// Database, as a PDO DSN (http://uk2.php.net/manual/en/pdo.construct.php)
$config['modules']['db']['dsn'] = 'sqlite:db.sqlite';

// rTorrent RPC interface URI, in protocol://user:password@host:port/path format
$config['modules']['rtorrent']['rpc_uri'] = 'http://rtorrent:password@localhost/RPC2';
