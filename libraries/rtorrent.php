<?php

class rTorrent
{
    // Priorities
    const PRIORITY_OFF    = 0;
    const PRIORITY_NORMAL = 1;
    const PRIORITY_HIGH   = 2;
    // Torrent priorities
    const TORRENT_PRI_OFF    = 0;
    const TORRENT_PRI_LOW    = 1;
    const TORRENT_PRI_NORMAL = 2;
    const TORRENT_PRI_HIGH   = 3;

    // Valid views
    public static $VIEWS = array('', 'default');

    // Torrent info query for d.multicall, as a map of info key to RPC command
    public static $VIEW_INFO_QUERY = array(
        'id'        => 'd.get_hash=',
        'name'      => 'd.get_name=',
    );

    // rTorrent client options
    protected $_options = array(
        // XML-RPC URI for rTorrent
        'rpc_uri' => 'http://localhost/RPC2',
    );

    // XML-RPC client instance
    protected $_rpc = null;


    public function __construct($options = array())
    {
        $this->_options = array_merge($this->_options, $options);
        $this->_rpc = new xmlrpc_client($this->_options['rpc_uri']);
    }

    public function get_torrents($view = '')
    {
        $args = array(new xmlrpcval($view, 'string'));
        foreach (array_values(self::$VIEW_INFO_QUERY) as $cmd)
            $args[] = new xmlrpcval($cmd, 'string');
        $msg = new xmlrpcmsg('d.multicall', $args);
        $resp = $this->_rpc->send($msg);

        $results = array();
        foreach (php_xmlrpc_decode($resp->value()) as $r)
            $results[] = array_combine(array_keys(self::$VIEW_INFO_QUERY), $r);

        return $results;
    }
}


class Torrent
{
    public function __construct($rtorrent, $hash, $info)
    {
    }
}


class TorrentFile
{
    public function __construct($rtorrent, $hash, $index)
    {
    }
}
