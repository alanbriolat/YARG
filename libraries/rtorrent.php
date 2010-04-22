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
        'downrate'  => 'd.get_down_rate=',
        'uprate'    => 'd.get_up_rate=',
        'size'      => 'd.get_size_bytes=',
        'chunk_size'        => 'd.get_chunk_size=',
        'total_chunks'      => 'd.get_size_chunks=',
        'completed_chunks'  => 'd.get_completed_chunks=',
        'ratio'             => 'd.get_ratio=',
        'is_open'           => 'd.is_open=',
        'is_active'         => 'd.is_active=',
        'is_complete'       => 'd.get_complete=',
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
        {
            $torrent = array_combine(array_keys(self::$VIEW_INFO_QUERY), $r);

            // XXX: This is a crude workaround for xmlrpc versions < 1.7 not
            // coping with 64-bit integers.  Unfortunately, most people only
            // have 1.6 unless they build rtorrent from source...  Without this,
            // large byte counts (> 2^31) wrap around to negative numbers.
            $torrent['size'] = $torrent['chunk_size'] * $torrent['total_chunks'];
            $torrent['completed_size'] = $torrent['chunk_size'] * $torrent['completed_chunks'];

            // Sanitised variables
            $torrent['ratio'] = round($torrent['ratio'] / 1000, 2);

            // Synthesised variables
            $torrent['completed_percent'] = round($torrent['completed_size'] / $torrent['size'] * 100);

            // Figure out the torrent state
            if ($torrent['is_open'] == 0) {
                $torrent['state'] = 'closed';
            } else if ($torrent['is_active'] == 1) {
                if ($torrent['is_complete'] == 1) {
                    $torrent['state'] = 'seeding';
                } else {
                    $torrent['state'] = 'downloading';
                }
            } else {
                $torrent['state'] = 'stopped';
            }
            $results[] = $torrent;
        }

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

        $values['downrate'] = round($values['downrate'] / 1024, 2).'K';
        $values['uprate'] = round($values['uprate'] / 1024, 2).'K';

        if (is_dir($values['directory']))
        {
            $values['have_disk_space'] = true;
            $disk_total = disk_total_space($values['directory']);
            $disk_free = disk_free_space($values['directory']);
            $disk_used = round($disk_total - $disk_free);
            $values['disk_total'] = $disk_total;
            $values['disk_free'] = $disk_free;
            $values['disk_used'] = $disk_used;
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
