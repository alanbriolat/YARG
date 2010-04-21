<? $TPL->extend('base'); ?>

<? $TPL->block('body'); ?>

<table>
<thead>
<tr>
<th>Name <?=icon('arrow_up')?><?=icon('arrow_down')?></th>
</tr>
</thead>
<tbody>
<? foreach ($C['torrents'] as $t): ?>
<tr>
    <td><?=anchor("torrent/{$t['id']}", $t['name'])?></td>
</tr>
<? endforeach; ?>
</tbody>
</table>

<? $TPL->endblock(); ?>
