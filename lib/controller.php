<?php

class Controller extends CSF_Controller
{
    protected $C = array();

    public function __construct()
    {
        $this->C['sysinfo'] = $this->rtorrent->get_sysinfo();
    }
}
