<?php

CSF::load_library('rtorrent');
CSF::register($MODULE_NAME, new rTorrent($MODULE_CONF));
