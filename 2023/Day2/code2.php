<?php

$game = 0;

$FILE = fopen($argv[1], "r") or die("Couldn't open file!");

$sum = 0;
while (($line = fgets($FILE)) !== false) {
    $game++;
    $lines = explode(":", $line);
    $line = isset($lines[1]) ? $lines[1] : "";

    $sum += powerOfSets(explode(";", $line));

}
echo "Sum : $sum\n\n";

function powerOfSets($sets) {
    $minRed = 0;
    $minGreen = 0;
    $minBlue = 0;

    foreach($sets as $set) {
        $set = strtolower($set);
        preg_match_all("|(\d+) ([rgb])|", $set, $matches);
        if(is_array($matches[2])) {
            foreach($matches[2] as $idx => $color) {
                switch($color) {
                    case 'r':
                        if($matches[1][$idx] > $minRed) $minRed = $matches[1][$idx];
                        break;
                    case 'g':
                        if($matches[1][$idx] > $minGreen) $minGreen = $matches[1][$idx];
                        break;
                    case 'b':
                        if($matches[1][$idx] > $minBlue) $minBlue = $matches[1][$idx];
                        break;
                }
            }
        }
    }

    print $minRed * $minGreen * $minBlue;
    print "\n";

    return $minRed * $minGreen * $minBlue;
}

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