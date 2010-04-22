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
    public static $VIEWS = array('default', 'active', 'incomplete', 'seeding');

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

    public function get_sysinfo()
    {
        $msgs = array();
        $msgs[] = new xmlrpcmsg('get_down_rate', array());
        $msgs[] = new xmlrpcmsg('get_up_rate', array());
        $msgs[] = new xmlrpcmsg('get_directory', array());
        $resps = $this->_rpc->multicall($msgs);
        $values = array();
        foreach ($resps as $r)
            $values[] = php_xmlrpc_decode($r->value());
        $values = array_combine(array('downrate', 'uprate', 'directory'), $values);

        $values['downrate'] = magnitude_adjust($values['downrate'], 1024, 800);
        $values['uprate'] = magnitude_adjust($values['uprate'], 1024, 800);

        if (is_dir($values['directory']))
        {
            $values['have_disk_space'] = true;
            $disk_total = disk_total_space($values['directory']);
            $disk_free = disk_free_space($values['directory']);
            $disk_used = round($disk_total_space - $disk_free_space);
            $values['disk_total'] = magnitude_adjust($disk_total, 1024, 1024);
            $values['disk_free'] = magnitude_adjust($disk_free, 1024, 1024);
            $values['disk_used'] = magnitude_adjust($disk_used, 1024, 1024);
            $values['disk_percent_used'] = round(($disk_used / $disk_total) * 100);
            $values['disk_percent_free'] = round(($disk_free / $disk_total) * 100);
        }
        else
        {
            $values['have_disk_space'] = false;
        }

        return $values;
    }

    public function get_counts()
    {

        $msgs = array();

        foreach (self::$VIEWS as $v)
            $msgs[] = new xmlrpcmsg('download_list', array(new xmlrpcval($v, 'string')));
        $resps = $this->_rpc->multicall($msgs);
        
        $counts = array();
        foreach ($resps as $r)
            $counts[] = count(php_xmlrpc_decode($r->value()));

        return array_combine(self::$VIEWS, $counts);
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
