<?php
function convert_time($time) {
    $time_c = date_create($time);
    return date_format($time_c, "H:i");
}

function alert($text) {
    echo "<script>alert('{$text}')</script>";
}

