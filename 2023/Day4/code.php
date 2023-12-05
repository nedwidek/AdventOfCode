<?php

$FILE = fopen($argv[1], "r") or die("Couldn't open file!");

$sum = 0;
while(($line = fgets($FILE)) !== false) {
    $colon = strpos($line, ":");
    $pipe = strpos($line, "|");
    $winners = array_filter(explode(" ", substr($line, $colon + 1, $pipe - $colon - 1)));
    $myNums = array_filter(explode(" ", substr($line, $pipe + 1, -1)));
    
    $matches = count(array_intersect($winners, $myNums));
    print "# of matches: {$matches}\n";
    $points = 0;
    if ($matches > 0) {
        $points = pow(2, $matches - 1);    
    }
    print "Worth: {$points}\n\n";
    $sum += $points;
}

print "\n\nSum: {$sum}\n\n";