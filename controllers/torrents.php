<?php

class Torrents extends Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->C['page'] = 'torrents';
    }

    public function list_($view = 'default')
    {
        $this->C['subpage'] = $view;
        $this->C['torrents'] = $this->rtorrent->get_torrents($view);
        return $this->template->render('torrentlist', $this->C);
    }

    public function json_list($view = 'default')
    {
        $torrents = $this->rtorrent->get_torrents($view);
        return json_encode($torrents);
    }
}
