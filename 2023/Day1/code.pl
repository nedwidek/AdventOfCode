#!/bin/perl

use 5.10.0;

open(FILE, $ARGV[0]) or die("Couldn't open file: $ARGV[0]");

$sum = 0;
foreach $line (<FILE>) {
    @matches = ($line =~ /(\d|oneight|twone|eighthree|eightwo|sevenine|one|two|three|four|five|six|seven|eight|nine|zero)/g);
    $num = convert($matches[0], 0) . convert($matches[$#matches], 1);
    $sum += $num + 0;
}

print "$sum\n";

sub convert {
    my $num = shift;
    my $isSecond = shift;

    $num = lc($num);
    given($num) {
        when("oneight") {
            if($isSecond) { return 8; }
            return 1;
        }
        when("twone") {
            if($isSecond) { return 1; }
            return 2;
        }
        when ("sevenine") {
            if($isSecond) { return 9; }
            return 7; 
        }
        when ("eightwo") {
            if($isSecond) { return 2; }
            return 8;
        }
        when ("eighthree")  {
            if($isSecond) { return 3; }
            return 8;
        }
        return 1 when ("one");
        return 2 when ("two");
        return 3 when ("three");
        return 4 when ("four");
        return 5 when ("five");
        return 6 when ("six");
        return 7 when ("seven");
        return 8 when ("eight");
        return 9 when ("nine");
        return 0 when ("zero");
        default { return $num; }
    }
}