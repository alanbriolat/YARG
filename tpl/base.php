<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd"> 
<html xmlns="http://www.w3.org/1999/xhtml"> 
    <head> 
        <title>YARG</title>
        <meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
        <link rel="stylesheet" type="text/css" href="<?=site_url('lessc.php?style.less')?>" />
        <script type="text/javascript" src="<?=site_url('js/jquery-1.4.2.min.js')?>"></script>
        <script type="text/javascript">
            var YARG = <?=json_encode(array(
                'base_url' => CSF::config('url_functions.base_url'),
                'refresh_interval' => 2000,
                'current' => array(
                    'page' => $C['page'],
                    'subpage' => $C['subpage'],
                ),
            ))?>;
        </script>
        <script type="text/javascript" src="<?=site_url('js/yarg.util.js')?>"></script>
        <script type="text/javascript" src="<?=site_url('js/yarg.js')?>"></script>
    </head>
    <body>
        <div id="header">
            <div id="navigation">
                <ul>
                    <li><a class="hasicon <?=ifeq($C['page'], 'torrents', 'current')?>" href="<?=site_url('')?>" style="<?=icon_css('drive_go')?>">Torrents</a></li>
                    <li><a class="hasicon <?=ifeq($C['page'], 'add', 'current')?>" href="<?=site_url('feeds')?>" style="<?=icon_css('feed')?>">Feeds</a></li>
                    <li><a class="hasicon <?=ifeq($C['page'], 'settings', 'current')?>" href="<?=site_url('settings')?>" style="<?=icon_css('cog')?>">Settings</a></li>
                </ul>
            </div>

            <h1 id="title">Yet Another rTorrent GUI</h1>

            <div class="clearer">&nbsp;</div>

            <span class="sysinfo">
            <span class="hasicon downrate" style="display: inline-block; width: 70px; <?=icon_css('arrow_down')?>" title="total download rate"><?=$C['sysinfo']['downrate']?>B/s</span>&nbsp;
            <span class="hasicon uprate" style="display: inline-block; width: 70px; <?=icon_css('arrow_up')?>" title="total upload rate"><?=$C['sysinfo']['uprate']?>B/s</span>&nbsp;
            <? if ($C['sysinfo']['have_disk_space']): ?>
            <span class="hasicon" style="<?=icon_css('drive')?>">
            <span class="progbar_outer" title="<?=nice_byte_count($C['sysinfo']['disk_free'])?>B free (<?=$C['sysinfo']['disk_percent_free']?>%)">
                <span class="progbar_inner" style="width: <?=$C['sysinfo']['disk_percent_used']?>%;" title="<?=nice_byte_count($C['sysinfo']['disk_used'])?>B used (<?=$C['sysinfo']['disk_percent_used']?>%)">&nbsp;</span>
            </span>
            <?=nice_byte_count($C['sysinfo']['disk_used'])?>B / <?=nice_byte_count($C['sysinfo']['disk_total'])?>B
            </span>
            <? endif; ?>
            </span>

            <div id="subnavigation">
                <ul>
                    <li><a class="<?=ifeq($C['subpage'], 'default', 'current')?>" href="<?=site_url('torrents/list')?>">All</a></li>
                    <li><a class="<?=ifeq($C['subpage'], 'active', 'current')?>" href="<?=site_url('torrents/list/active')?>">Active</a></li>
                    <li><a class="<?=ifeq($C['subpage'], 'incomplete', 'current')?>" href="<?=site_url('torrents/list/incomplete')?>">Incomplete</a></li>
                    <li><a class="<?=ifeq($C['subpage'], 'seeding', 'current')?>" href="<?=site_url('torrents/list/seeding')?>">Seeding</a></li>
                </ul>
            </div>
        </div>
        <div id="content_outer">
        <div id="content">
        <? $TPL->block('body'); ?>
        <? $TPL->endblock(); ?>
        </div>
        </div>
    </body>
</html>
