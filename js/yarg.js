var torrent_row_blank = $('\
<tbody id="" class=""> \
<tr> \
    <td><input type="checkbox" name="torrents[]" value="" /></td> \
    <td colspan="3" class="name"><a href=""></a></td> \
    <td colspan="3" class="rightalign"> \
        <a class="start" href="" title="start">'+icon('control_play')+'</a> \
        <a class="stop" href="" title="stop">'+icon('control_pause')+'</a> \
        <a class="close" href="" title="close">'+icon('control_stop')+'</a> \
        <a class="remove" href="" title="remove">'+icon('control_eject')+'</a> \
    </td> \
</tr> \
<tr> \
    <td></td> \
    <td> \
        <span class="progress_outer" style="width: 100%;" title=""><span class="progress_inner" style="">&nbsp;</span></span> \
    </td> \
    <td class="completed_percent"></td> \
    <td class="size"></td> \
    <td class="rightalign downrate"></td> \
    <td class="rightalign uprate"></td> \
    <td class="rightalign ratio"></td> \
</tr> \
</tbody> \
');

function schedule_update() {
    window.setTimeout(update_display, YARG.refresh_interval);
}

function update_display() {
    $.getJSON(YARG.base_url + 'json/system/info', update_sysinfo);
    $.getJSON(YARG.base_url + 'json/torrents/list/' + YARG.current.subpage, update_torrents);

    // Reschedule display update
    schedule_update();
}

function update_sysinfo(data) {
    $('#header .sysinfo .downrate').text(data.downrate + 'B/s');
    $('#header .sysinfo .uprate').text(data.uprate + 'B/s');
}

function update_torrents(data) {
    var torrents = $('#torrentlist tbody[id^=torrent_]');

    for (var i in data) {
        var t = data[i];
        var row = torrents.filter('#torrent_' + t.id);

        // If this torrent isn't already in the view, create a new one
        if (row.length == 0) {
            row = torrent_row_blank.clone();
            torrent_row_init(row, t);
            row.insertAfter('#torrentlist thead');
        }
        
        // Update and mark as being in the view
        torrent_row_update(row, t);
        row.addClass('is_live');
    }

    // Prune torrents not in this view
    torrents.filter(':not(.is_live)').remove();
    torrents.removeClass('is_live');
}

function torrent_row_init(row, t) {
    row.attr('id', 'torrent_' + t.id);
    $('input[type=checkbox]', row).val(t.id);
    $('.name > a', row).text(t.name).attr('href', site_url('torrents/view/' + t.id));
    $('a.start', row).attr('href', site_url('torrents/start/' + t.id));
    $('a.stop', row).attr('href', site_url('torrents/stop/' + t.id));
    $('a.close', row).attr('href', site_url('torrents/close/' + t.id));
    $('a.remove', row).attr('href', site_url('torrents/remove/' + t.id));
    $('.size', row).text(t.size);
}

function torrent_row_update(row, t) {
    row.attr('class', t.state);
    $('.progress_outer', row).attr('title', t.state + ': ' + t.progress + '%');
    $('.progress_inner', row).css('width', t.progress_bar + '%');
    $('.completed_percent', row).text(t.progress + '%');
    $('.downrate', row).text(t.downrate);
    $('.uprate', row).text(t.uprate);
    $('.ratio', row).text(t.ratio).toggleClass('good', t.ratio >= 1.0).toggleClass('bad', t.ratio < 1.0);
}
