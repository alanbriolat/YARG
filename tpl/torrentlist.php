<? $TPL->extend('base'); ?>

<? $TPL->block('body'); ?>

<script type="text/javascript">
    $(document).ready(function () {
        schedule_update();
        $('#torrentlist thead input[type=checkbox]').click(function () {
            $('#torrentlist input[type=checkbox]').attr('checked', $(this).is(':checked'));
        });
        $('#torrentlist tbody').click(function () {
            var el = $('input[type=checkbox]', this);
            el.attr('checked', !el.is(':checked'));
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
<table>
<thead>
<tr id="torrent_top">
    <th style="width: 10px;"><input type="checkbox" /></th>
    <th>Name</th>
    <th style="width: 70px;">Progress</th>
    <th style="width: 70px;">Size</th>
    <th style="width: 70px;">DL rate</th>
    <th style="width: 70px;">UL rate</th>
    <th style="width: 40px;">Ratio</th>
</tr>
</thead>
<? foreach ($C['torrents'] as $t): ?>
<tbody id="torrent_<?=$t['id']?>" class="<?=$t['state']?>">
<tr>
    <td><input type="checkbox" name="torrents[]" value="<?=$t['id']?>" /></td>
    <td colspan="3" class="name"><?=anchor("torrents/view/{$t['id']}", $t['name'])?></td>
    <td colspan="3" class="rightalign">
        <a class="start" href="<?=site_url('torrents/start/'.$t['id'])?>" title="start"><?=icon('control_play')?></a>
        <a class="stop" href="<?=site_url('torrents/stop/'.$t['id'])?>" title="stop"><?=icon('control_pause')?></a>
        <a class="close" href="<?=site_url('torrents/close/'.$t['id'])?>" title="close"><?=icon('control_stop')?></a>
        <a class="remove" href="<?=site_url('torrents/remove/'.$t['id'])?>" title="remove"><?=icon('control_eject')?></a>
    </td>
</tr>
<tr>
    <td></td>
    <td>
        <span class="progbar_outer" style="width: 100%;" title="<?=$t['state']?>: <?=$t['progress']?>%"><span class="progbar_inner" style="width: <?=$t['progress_bar']?>%;">&nbsp;</span></span>
    </td>
    <td class="progress"><?=$t['progress']?>%</td>
    <td class="rightalign size"><?=$t['size']?></td>
    <td class="rightalign downrate"><?=$t['downrate']?></td>
    <td class="rightalign uprate"><?=$t['uprate']?></td>
    <td class="rightalign ratio <?=($t['ratio'] < 1.0 ? 'bad' : 'good')?>"><?=$t['ratio']?></td>
</tr>
</tbody>
<? endforeach; ?>
</table>
</div>

<? $TPL->endblock(); ?>
