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
<span class="closed"><span class="progress_outer"><span class="progress_inner">&nbsp;</span></span></span> closed
<span class="stopped"><span class="progress_outer"><span class="progress_inner">&nbsp;</span></span></span> stopped
<span class="downloading"><span class="progress_outer"><span class="progress_inner">&nbsp;</span></span></span> downloading
<span class="seeding"><span class="progress_outer"><span class="progress_inner">&nbsp;</span></span></span> seeding
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
        <span class="progress_outer" style="width: 100%;" title="<?=$t['state']?>: <?=$t['completed_percent']?>%"><span class="progress_inner" style="width: <?=$t['progress']?>%;">&nbsp;</span></span>
    </td>
    <td class="completed_percent"><?=$t['completed_percent']?>%</td>
    <td class="size"><?=nice_byte_count($t['size'])?>B</td>
    <td class="rightalign downrate"><?=nice_byte_count($t['downrate'])?>B/s</td>
    <td class="rightalign uprate"><?=nice_byte_count($t['uprate'])?>B/s</td>
    <td class="rightalign ratio <?=($t['ratio'] < 1.0 ? 'bad' : 'good')?>"><?=$t['ratio']?></td>
</tr>
</tbody>
<? endforeach; ?>
</table>
</div>

<? $TPL->endblock(); ?>
