<?php

/**
 * Generate the info hash for a torrent
 *
 * @param   string  $filedata   Contents of the torrent file
 * @return  string  SHA1 hash of info section, or null on failure
 */
function naive_torrent_hash($filedata)
{
    // Find start of info section
    $startpos = strpos($filedata, '4:info');
    if ($startpos === false) return null;
    // Create SHA1 hash of the rest of the data, excluding the final 'e' (which
    // closes the outer dictionary)
    return sha1(substr($filedata, $pos + 6, -1));
}

/**
 * Convert a value to a magnitude-adjusted string
 *
 * Adjust a value so that there are no more than 3 digits before the decimal
 * point.
 *
 * @param   int     $value
 * @param   int     $div
 * @param   int     $threshold
 * @param   int     $maxprecision
 * @param   int     $strip
 * @return  string
 */
function magnitude_adjust($value, $div = 1000, $threshold = 1000,
                          $maxprecision = 2, $strip = true)
{
    $suffixes = array('', 'K', 'M', 'G', 'T', 'P');
    $format = '%.'.$maxprecision.'f';

    // Calculate new value and which suffix to use
    $suffix = 0;
    while ($value >= $threshold)
    {
        $value /= $div;
        $suffix += 1;
    }

    // Convert to string
    $value = sprintf($format, $value);
    // Strip trailing 0s and possibly decimal point
    $value = rtrim($value, '0.,');
    // Make sure it's not empty!
    if ($value === '')
        $value = '0';

    return $value.$suffixes[$suffix];
}

/**
 * Make a "byte count" more readable
 * 
 * Heavily inspired by a similar function in wTorrent (getCorrectUnits in
 * cls/rtorrent.cls.php).
 */
function nice_byte_count($value)
{
    $suffixes = array(array('', '0'), array('K', '1'), array('M', 2),
                      array('G', 2), array('T', 3), array('P', 3));

    $i = 0;
    for (; $i < (count($suffixes) - 1) && $value > 900; ++$i)
        $value /= 1024;

    return sprintf('%.'.$suffixes[$i][1].'f%s', $value, $suffixes[$i][0]);
}
