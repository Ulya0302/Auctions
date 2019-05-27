<?php
function convert_time($time) {
    $time_c = date_create($time);
    return date_format($time_c, "H:i");
}

function error($text)
{
    echo "<div class='error-block'>$text</div>";
}

function success($text)
{
    echo "<div class='success-block'>$text</div>";
}
