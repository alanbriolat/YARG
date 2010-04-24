function nice_byte_count(value) {
    var suffixes = [['', 0], ['K', 1], ['M', 2], ['G', 2], ['T', 3], ['P', 3]];
    var i = 0;

    for (; i < suffixes.length - 1 && value > 900; ++i)
    {
        value /= 1024.0;
    }

    return (new Number(value)).toFixed(suffixes[i][1]) + suffixes[i][0];
}
