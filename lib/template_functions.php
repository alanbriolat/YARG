<?php

/**
 * Create the HTML fragment for an icon image
 *
 * @param   string  $icon   The name of the icon
 * @return  string  HTML fragment (<img> tag)
 */
function icon($icon, $alt = '')
{
    return sprintf('<img class="icon" src="%s" alt="%s" />', site_url("icons/$icon.png"), $alt);
}

/**
 * Create the CSS fragment required to set a particular icon
 *
 * @param   string  $icon   The name of the icon
 * @return  string  CSS fragment (put it in a style="")
 */
function icon_css($icon)
{
    return sprintf('background-image: url(%s);', site_url("icons/$icon.png"));
}

/**
 * If $a == $b, return $c, else return $d
 *
 * Useful for setting "current" class on things like navigation, i.e.
 * class="<?=ifeq($C['currentpage'], 'foo', 'current)?>".
 *
 * @param   mixed   $a
 * @param   mixed   $b
 * @param   mixed   $c
 * @param   mixed   $d      [default: '']
 * @return  mixed
 */
function ifeq($a, $b, $c, $d = '')
{
    return ($a == $b) ? $c : $d;
}
