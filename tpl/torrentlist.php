<? $TPL->extend('base'); ?>

<? $TPL->block('body'); ?>

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
    <th style="width: 100px;">Status</th>
    <th class="rightalign" style="width: 70px;">Size /<br />Ratio</th>
    <th class="rightalign" style="width: 70px;">DL rate</th>
    <th class="rightalign" style="width: 70px;">UL rate</th>
</tr>
</thead>
<? foreach ($C['torrents'] as $t): ?>
<tbody id="torrent_<?=$t['id']?>" class="<?=$t['state']?>">
<tr>
    <td><input type="checkbox" name="torrents[]" value="<?=$t['id']?>" /></td>
    <td colspan="2"><?=anchor("torrent/{$t['id']}", $t['name'])?></td>
    <td class="rightalign"><?=nice_byte_count($t['size'])?>B</td>
    <td class="rightalign"><?=nice_byte_count($t['downrate'])?>B/s</td>
    <td class="rightalign"><?=nice_byte_count($t['uprate'])?>B/s</td>
</tr>
<tr>
    <td></td>
    <td><span class="progress_outer" style="width: 100%;" title="<?=$t['state']?>: <?=$t['completed_percent']?>%"><span class="progress_inner" style="width: <?=$t['progress']?>%;">&nbsp;</span></span></td>
    <td><?=$t['completed_percent']?>%</td>
    <td class="rightalign ratio"><span title="seed ratio" class="<?=($t['ratio'] < 1.0 ? 'bad' : 'good')?>"><?=$t['ratio']?></span></td>
    <td colspan="2"></td>
</tr>
</tbody>
<? endforeach; ?>
</table>
</div>

<? $TPL->endblock(); ?>
