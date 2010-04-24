function schedule_update()
{
    window.setTimeout(update_display, YARG.refresh_interval);
}

function update_display()
{
    $.getJSON(YARG.base_url + 'json/system/info', update_sysinfo);
    //$.getJSON(YARG.base_url + 'json/torrents/list/' + YARG.current.subpage, update_torrents);

    // Reschedule display update
    schedule_update();
}

function update_sysinfo(data)
{
    $('#header .sysinfo .downrate').text(data.downrate + 'B/s');
    $('#header .sysinfo .uprate').text(data.uprate + 'B/s');
}

function update_torrents(data)
{
}
