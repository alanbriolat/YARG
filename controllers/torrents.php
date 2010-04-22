<?php

class Torrents extends Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->C['page'] = 'torrents';
    }

    public function torrent_list($view = 'default')
    {
        $this->C['subpage'] = $view;
        $this->C['torrents'] = $this->rtorrent->get_torrents($view);
        return $this->template->render('torrentlist', $this->C);
    }
}
