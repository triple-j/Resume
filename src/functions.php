<?php
function alink($link, $prefix="http://") {
    return "<a href=\"{$prefix}{$link}\" target=\"_blank\">{$link}</a>";
}

function email($link) {
    $href = "mailto:" . strtolower($link);
    return "<a href=\"{$href}\">{$link}</a>";
}