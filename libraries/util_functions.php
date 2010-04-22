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

    return $value.$suffixes[$suffix];
}
