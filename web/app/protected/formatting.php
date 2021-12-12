<?php

namespace Misc\Formatter;

class Formatter {
    function shorten_description(string $description, int $limit, bool $newlines = false) {
        $description = trim($description);
        if(strlen($description) >= $limit) {
            $description = substr($description, 0, $limit) . "...";
        } 

        $description = htmlspecialchars($description);
        if($newlines) { $description = str_replace(PHP_EOL, "<br>", $description); }
        $description = preg_replace("/@([a-zA-Z0-9-]+|\\+\\])/", "<a href='/user/$1'>@$1</a>", $description);
        $description = preg_replace("/((\d{1,2}:)+\d{2})/", "<a onclick=\"yt.www.watch.player.seekTo('$1', false)\">$1</a>", $description);
        return $description;
    }
}