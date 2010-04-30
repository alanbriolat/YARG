<? $TPL->extend('base'); ?>

<? $TPL->block('body'); ?>

<script type="text/javascript">
    $(document).ready(function () {
        // Start automatic updating
        schedule_update();

        // Operations on all checkboxes
        $('#torrentlist .groupaction .selectall').click(function (event) {
            event.preventDefault();
            $('#torrentlist input[type=checkbox]').attr('checked', true);
        });
        $('#torrentlist .groupaction .selectinverse').click(function (event) {
            event.preventDefault();
            $('#torrentlist input[type=checkbox]').each(function () {
                this.checked = !this.checked;
            });
        });
        $('#torrentlist .groupaction .selectnone').click(function (event) {
            event.preventDefault();
            $('#torrentlist input[type=checkbox]').attr('checked', false);
        });

        // Clicking a row toggles it's selection state
        /* TODO: Re-enable this?
        $('#torrentlist tbody').click(function () {
            var el = $('input[type=checkbox]', this);
            el.attr('checked', !el.is(':checked'));
        });
        */

        // Prevent <a> click events from propagating
        $('#torrentlist a').click(function (event) {
            event.stopPropagation();
        });
    });
</script>

<p id="status_key">
Key:
<span class="closed"><span class="progbar_outer"><span class="progbar_inner">&nbsp;</span></span></span> closed
<span class="stopped"><span class="progbar_outer"><span class="progbar_inner">&nbsp;</span></span></span> stopped
<span class="downloading"><span class="progbar_outer"><span class="progbar_inner">&nbsp;</span></span></span> downloading
<span class="seeding"><span class="progbar_outer"><span class="progbar_inner">&nbsp;</span></span></span> seeding
</p>


<div id="torrentlist">

<div class="groupaction">
<a href="#" class="selectall">Select all</a> |
<a href="#" class="selectinverse">Invert selection</a> |
<a href="#" class="selectnone">Select none</a>
</div>

<ul>
<? foreach ($C['torrents'] as $t): ?>
    <li id="torrent_<?=$t['id']?>" class="torrent <?=$t['state']?>">
        <span class="name">
            <input type="checkbox" name="torrents[]" value="<?=$t['id']?>" />
            <a class="value" href="<?=site_url("torrents/view/{$t['id']}")?>"><?=$t['name']?></a>
        </span>
        <ul class="info">
            <li class="progress"><span class="label">Progress:</span> <span class="value"><?=$t['progress']?></span>%</li>
            <li class="size"><span class="label">Size:</span> <span class="value"><?=$t['size']?></span></li>
            <li class="downrate"><span class="label">DL:</span> <span class="value"><?=$t['downrate']?></span></li>
            <li class="uprate"><span class="label">UL:</span> <span class="value"><?=$t['uprate']?></span></li>
            <li class="ratio"><span class="label">Ratio:</span> <span class="value <?=($t['ratio'] < 1.0 ? 'bad' : 'good')?>"><?=$t['ratio']?></span></li>
            <li class="buttons"><span class="label">Actions:</span>&nbsp;<a class="start" href="<?=site_url('torrents/start/'.$t['id'])?>" title="start"><?=icon('control_play')?></a>&nbsp;<a class="stop" href="<?=site_url('torrents/stop/'.$t['id'])?>" title="stop"><?=icon('control_pause')?></a>&nbsp;<a class="close" href="<?=site_url('torrents/close/'.$t['id'])?>" title="close"><?=icon('control_stop')?></a>&nbsp;<a class="remove" href="<?=site_url('torrents/remove/'.$t['id'])?>" title="remove"><?=icon('control_eject')?></a></li>
            <li class="progressbar"><div class="progbar_outer" style="width: 100%;" title="<?=$t['state']?>: <?=$t['progress']?>%"><div class="progbar_inner" style="width: <?=$t['progress_bar']?>%;">&nbsp;</div></div></li>
        </ul>
    </li>
<? endforeach; ?>
</ul>

</div>

<? $TPL->endblock(); ?>
