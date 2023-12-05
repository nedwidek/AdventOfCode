<?php

define('REDS', 12);
define('GREENS', 13);
define('BLUES', 14);

$game = 0;

$FILE = fopen($argv[1], "r") or die("Couldn't open file!");

$valid = array();
$sum = 0;
while (($line = fgets($FILE)) !== false) {
    $game++;
    $lines = explode(":", $line);
    $line = isset($lines[1]) ? $lines[1] : "";
    if(sets_valid(explode(";", $line))) {
        $valid[] = $game;
        $sum += $game;
    }
}
echo "\nValid games are: " . implode(', ', $valid) . "\n\n";
echo "Sum : $sum\n\n";

function sets_valid($sets) {
    foreach($sets as $set) {
        $set = strtolower($set);
        preg_match_all("|(\d+) ([rgb])|", $set, $matches);
        if(is_array($matches[2])) {
            foreach($matches[2] as $idx => $color) {
                switch($color) {
                    case 'r':
                        if($matches[1][$idx] > REDS) return false;
                        break;
                    case 'g':
                        if($matches[1][$idx] > GREENS) return false;
                        break;
                    case 'b':
                        if($matches[1][$idx] > BLUES) return false;
                        break;
                }
            }
        }
    }
    return true;
}