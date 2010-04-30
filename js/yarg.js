var torrent_row_blank = $('\
    <li id="" class="torrent">\
        <span class="name">\
            <input type="checkbox" name="torrents[]" value="" />\
            <a class="value" href=""></a>\
        </span>\
        <ul class="info">\
            <li class="progress"><span class="label">Progress:</span> <span class="value"></span>%</li>\
            <li class="size"><span class="label">Size:</span> <span class="value"></span></li>\
            <li class="downrate"><span class="label">DL:</span> <span class="value"></span></li>\
            <li class="uprate"><span class="label">UL:</span> <span class="value"></span></li>\
            <li class="ratio"><span class="label">Ratio:</span> <span class="value"></span></li>\
            <li class="buttons"><span class="label">Actions:</span>&nbsp;<a class="start" href="" title="start">'+icon('control_play')+'</a>&nbsp;<a class="stop" href="" title="stop">'+icon('control_pause')+'</a>&nbsp;<a class="close" href="" title="close">'+icon('control_stop')+'</a>&nbsp;<a class="remove" href="" title="remove">'+icon('control_eject')+'</a></li>\
            <li class="progressbar"><div class="progbar_outer" style="width: 100%;" title=""><div class="progbar_inner" style="">&nbsp;</div></div></li>\
        </ul>\
    </li>\
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
    var torrents = $('#torrentlist li[id^=torrent_]');

    for (var i in data) {
        var t = data[i];
        var row = torrents.filter('#torrent_' + t.id);

        // If this torrent isn't already in the view, create a new one
        if (row.length == 0) {
            row = torrent_row_blank.clone();
            torrent_row_init(row, t);
            row.prependTo('#torrentlist > ul');
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
    $('.name .value', row).text(t.name).attr('href', site_url('torrents/view/' + t.id));
    $('.buttons .start', row).attr('href', site_url('torrents/start/' + t.id));
    $('.buttons .stop', row).attr('href', site_url('torrents/stop/' + t.id));
    $('.buttons .close', row).attr('href', site_url('torrents/close/' + t.id));
    $('.buttons .remove', row).attr('href', site_url('torrents/remove/' + t.id));
    $('.size .value', row).text(t.size);
}

function torrent_row_update(row, t) {
    row.removeClass(['closed', 'stopped', 'downloading', 'seeding']);
    row.addClass(t.state);
    $('.progbar_outer', row).attr('title', t.state + ': ' + t.progress + '%');
    $('.progbar_inner', row).css('width', t.progress_bar + '%');
    $('.progress .value', row).text(t.progress);
    $('.downrate .value', row).text(t.downrate);
    $('.uprate .value', row).text(t.uprate);
    $('.ratio .value', row).text(t.ratio).toggleClass('good', t.ratio >= 1.0).toggleClass('bad', t.ratio < 1.0);
}
