<?php

$FILE = fopen($argv[1], "r") or die("Couldn't open file!");

$lines = array();
$lastLineNum = -1;
while (!feof($FILE)) {
    $lines[] = fgets($FILE);
    $lastLineNum++;
}

$lineLength = strlen($lines[0]) - 1;
$lineNum = -1;
$sum = 0;
do {
    $lineNum++;
    print "Processing line: {$lineNum}\n";
    $line = $lines[$lineNum];
    for($idx=0; $idx<$lineLength; $idx++) {
        if($line[$idx] === "*") {
            print "Found * character at {$idx}\n";
            $sum += findTangentialSum($lineNum, $idx);
        }
    }
} while ($lineNum < $lastLineNum);

print "Sum: {$sum}\n";

function findTangentialSum($lineNum, $idx) {
    global $lines, $lastLineNum;

    $gears = [];
    $prevLine = $lineNum - 1;
    $nextLine = $lineNum + 1;

    $start = $idx - 1;
    if($start > -1) {
        $ret = findNumAt($lines[$lineNum], $start);
        if($ret["start"] !== -1) {
            $gears[] = $ret["number"];
            print "Found immediate left: {$ret["number"]}\n";
        }
    }
    $start = $idx + 1;
    if($start < strlen($lines[$idx])) {
        $ret = findNumAt($lines[$lineNum], $start);
        if($ret["start"] !== -1) {
            $gears[] = $ret["number"];
            print "Found immediate right: {$ret["number"]}\n";
        }
    }
    $start = $idx - 1;
    if($prevLine > -1) {
        if($start > -1) {
            $ret = findNumAt($lines[$prevLine], $start);
            if($ret["start"] !== -1) {
                $gears[] = $ret["number"];
                print "Found upper left: {$ret["number"]}\n";
            }
        }
        $start = $idx;
        if($ret["end"] < $start) {
            $ret = findNumAt($lines[$prevLine], $start);
            if($ret["start"] !== -1) {
                $gears[] = $ret["number"];
                print "Found upper: {$ret["number"]}\n";
            }
        }
        $start = $idx + 1;
        if($ret["end"] < $start) {
            $ret = findNumAt($lines[$prevLine], $start);
            if($ret["start"] !== -1) {
                $gears[] = $ret["number"];
                print "Found upper right: {$ret["number"]}\n";
            }
        }
    }
    if($nextLine <= $lastLineNum) {
        $start = $idx - 1;
        if($start > -1) {
            $ret = findNumAt($lines[$nextLine], $start);
            if($ret["start"] !== -1) {
                $gears[] = $ret["number"];
                print "Found lower left: {$ret["number"]}\n";
            }
        }
        $start = $idx;
        if($ret["end"] < $start) {
            $ret = findNumAt($lines[$nextLine], $start);
            if($ret["start"] !== -1) {
                $gears[] = $ret["number"];
                print "Found lower: {$ret["number"]}\n";
            }
        }
        $start = $idx + 1;
        if($ret["end"] < $start) {
            $ret = findNumAt($lines[$nextLine], $start);
            if($ret["start"] !== -1) {
                $gears[] = $ret["number"];
                print "Found lower right: {$ret["number"]}\n";
            }
        }
    }

    if (count($gears) == 2) {
        return $gears[0] * $gears[1];
    }

    return 0;
}

function findNumAt($line, $idx) {
    $start = $idx;
    if(strpos("0123456789", $line[$start]) === false) return ["start" => -1, "end" => -1, "number" => 0];

    while($start > 0 && strpos("0123456789", $line[$start-1]) !== false) {
        $start--;
    }

    $end = $idx;
    while($end < strlen($line) && strpos("0123456789", $line[$end]) !== false) {
        $end++;
    }

    return ["start" => $start, "end" => $end, "number" => substr($line, $start, $end - $start)];

}