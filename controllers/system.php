<?php

class System extends Controller
{
    public function info_json()
    {
        return json_encode($this->C['sysinfo']);
    }
}
