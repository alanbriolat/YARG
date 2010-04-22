<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd"> 
<html xmlns="http://www.w3.org/1999/xhtml"> 
    <head> 
        <title>YARG</title>
        <meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
        <link rel="stylesheet" type="text/css" href="<?=site_url('lessc.php?style.less')?>" />
    </head>
    <body>
        <div id="header">
            <div id="navigation">
                <ul>
                    <li><a class="hasicon <?=ifeq($C['page'], 'torrents', 'current')?>" href="#" style="<?=icon_css('drive_go')?>">Torrents</a></li>
                    <li><a class="hasicon <?=ifeq($C['page'], 'add', 'current')?>" href="#" style="<?=icon_css('feed')?>">Feeds</a></li>
                    <li><a class="hasicon <?=ifeq($C['page'], 'settings', 'current')?>" href="#" style="<?=icon_css('cog')?>">Settings</a></li>
                </ul>
            </div>

            <h1 id="title">Yet Another rTorrent GUI</h1>

            <div class="clearer">&nbsp;</div>

            <span class="sysinfo">
            <span class="hasicon" style="<?=icon_css('arrow_down')?>"><?=$C['sysinfo']['downrate']?>B/s</span>&nbsp;
            <span class="hasicon" style="<?=icon_css('arrow_up')?>"><?=$C['sysinfo']['uprate']?>B/s</span>&nbsp;
            <? if ($C['sysinfo']['have_disk_space']): ?>
            <span class="hasicon" style="<?=icon_css('drive')?>">
            <span class="progress_outer" title="<?=nice_byte_count($C['sysinfo']['disk_free'])?>B free (<?=$C['sysinfo']['disk_percent_free']?>%)">
                <span class="progress_inner" style="width: <?=$C['sysinfo']['disk_percent_used']?>%;" title="<?=nice_byte_count($C['sysinfo']['disk_used'])?>B used (<?=$C['sysinfo']['disk_percent_used']?>%)">&nbsp;</span>
            </span>
            <?=nice_byte_count($C['sysinfo']['disk_used'])?>B / <?=nice_byte_count($C['sysinfo']['disk_total'])?>B
            </span>
            <? endif; ?>
            </span>

            <div id="subnavigation">
                <ul>
                    <li><a class="<?=ifeq($C['subpage'], 'default', 'current')?>" href="<?=site_url('')?>">All (<?=$C['counts']['default']?>)</a></li>
                    <li><a class="<?=ifeq($C['subpage'], 'active', 'current')?>" href="<?=site_url('list/active')?>">Active (<?=$C['counts']['active']?>)</a></li>
                    <li><a class="<?=ifeq($C['subpage'], 'incomplete', 'current')?>" href="<?=site_url('list/incomplete')?>">Incomplete (<?=$C['counts']['incomplete']?>)</a></li>
                    <li><a class="<?=ifeq($C['subpage'], 'seeding', 'current')?>" href="<?=site_url('list/seeding')?>">Seeding (<?=$C['counts']['seeding']?>)</a></li>
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
