<? $TPL->extend('base'); ?>

<? $TPL->block('body'); ?>

<p id="status_key">
Key:
<span class="closed"><span class="progress_outer"><span class="progress_inner">&nbsp;&nbsp;</span></span></span> closed
<span class="stopped"><span class="progress_outer"><span class="progress_inner">&nbsp;&nbsp;</span></span></span> stopped
<span class="downloading"><span class="progress_outer"><span class="progress_inner">&nbsp;&nbsp;</span></span></span> downloading
<span class="seeding"><span class="progress_outer"><span class="progress_inner">&nbsp;&nbsp;</span></span></span> seeding
</p>

<div id="torrentlist">
<table>
<thead>
<tr id="torrent_top">
    <th style="width: 10px"><input type="checkbox" /></th>
    <th>Name <?=icon('arrow_up')?><?=icon('arrow_down')?></th>
    <th style="width: 100px;">Status <?=icon('arrow_up')?><?=icon('arrow_down')?></th>
    <th class="rightalign" style="width: 70px;">Size <?=icon('arrow_up')?><?=icon('arrow_down')?></th>
    <th class="rightalign" style="width: 70px;">DL</th>
    <th class="rightalign" style="width: 70px;">UL</th>
</tr>
</thead>
<tbody>
<? foreach ($C['torrents'] as $t): ?>
<tr id="torrent_<?=$t['id']?>" class="<?=$t['state']?>">
    <td><input type="checkbox" name="torrents[]" value="<?=$t['id']?>" /></td>
    <td><?=anchor("torrent/{$t['id']}", $t['name'])?></td>
    <td><span class="progress_outer" style="width: 100%;" title="<?=$t['state']?>: <?=$t['completed_percent']?>%"><span class="progress_inner" style="width: <?=$t['completed_percent']?>%;">&nbsp;</span></span></td>
    <td class="rightalign"><?=nice_byte_count($t['size'])?>B</td>
    <td class="rightalign"><?=nice_byte_count($t['downrate'])?>B/s</td>
    <td class="rightalign"><?=nice_byte_count($t['uprate'])?>B/s</td>
</tr>
<? endforeach; ?>
</tbody>
</table>
</div>

<? $TPL->endblock(); ?>
