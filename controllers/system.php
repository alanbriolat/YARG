<?php

class System extends Controller
{
    public function json_info()
    {
        return json_encode($this->C['sysinfo']);
    }
}
