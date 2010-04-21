<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd"> 
<html xmlns="http://www.w3.org/1999/xhtml"> 
    <head> 
        <meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
        <link rel="stylesheet" type="text/css" href="<?=site_url('style.css')?>" />
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

            <h1 id="title">YARG</h1>
            <h2 id="subtitle">Yet Another Rtorrent GUI</h2>
        </div>
        <div id="body">
        <? $TPL->block('body'); ?>
        <? $TPL->endblock(); ?>
        </div>
    </body>
</html>
