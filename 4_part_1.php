<?php
/**
 * Created by PhpStorm.
 * User: mkl
 * Date: 10.01.2019
 * Time: 11:33
 */

/* Day 4: Repose Record*/

$records =file("4_inputData.txt");
$currentguard = null;
$lastminute = 0;
$awake = true;
$guardtotals = array();
function cmp_fun($a, $b) {
    preg_match('/\[([0-9]{4})\-([0-9]{2})\-([0-9]{2}) ([0-9]{2}):([0-9]{2})\]/', $a, $atimes);
    preg_match('/\[([0-9]{4})\-([0-9]{2})\-([0-9]{2}) ([0-9]{2}):([0-9]{2})\]/', $b, $btimes);
    if (intval($atimes[1].$atimes[2].$atimes[3].$atimes[4].$atimes[5]) == intval($btimes[1].$btimes[2].$btimes[3].$btimes[4].$btimes[5])) {
        return 0;
    }
    else if (intval($atimes[1].$atimes[2].$atimes[3].$atimes[4].$atimes[5]) < intval($btimes[1].$btimes[2].$btimes[3].$btimes[4].$btimes[5])){
        return -1;
    }
    else return 1;
}
usort($records,"cmp_fun");

foreach ($records as $record) {
    preg_match('/\[[0-9]{4}\-([0-9]{2})\-([0-9]{2}) ([0-9]{2}):([0-9]{2})\]/', $record, $timestamps);
    preg_match('/Guard #([0-9]+)/', $record, $guard);
    if (count($guard) > 0) {
        if (!$awake && $currentguard) {
            $timeasleep = 60 - $lastminute;
            $guardtotals[$currentguard]['asleep'] += $timeasleep;
            $sleep = array_slice($guardtotals[$currentguard]['minutes'], $lastminute, $timeasleep);
            $sleep = array_map(function($x) {  //array_map() returns an array containing all the elements of array1 after applying the callback function to each one.
                return $x+1;
            }, $sleep);

            array_splice($guardtotals[$currentguard]['minutes'], $lastminute, $timeasleep, $sleep);
            $lastminute = 0;
        }
        $currentguard = intval($guard[1]);
        $awake = true;
        if (!array_key_exists($currentguard, $guardtotals)) {
            $guardtotals[$currentguard] = array(
                'asleep' => 0,
                'minutes' => array_fill(0, 60, 0)
            );
        }
    } elseif (strpos($record, 'falls asleep')) { //strpos — Find the position of the first occurrence of a substring in a string
        $awake = false;
        $lastminute = intval($timestamps[4]);

    } elseif (strpos($record, 'wakes up')) {
        if ($currentguard) {
            $timeasleep = intval($timestamps[4]) - $lastminute;
            $guardtotals[$currentguard]['asleep'] += $timeasleep;
            $sleep = array_slice($guardtotals[$currentguard]['minutes'], $lastminute, $timeasleep);

            $sleep = array_map(function($x) {
                return $x+1;
            }, $sleep);

            array_splice($guardtotals[$currentguard]['minutes'], $lastminute, $timeasleep, $sleep);
            $lastminute = intval($timestamps[4]);
            $awake = true;
        }
    }
}
function cmp_fun1($a, $b) {
    if ($a['asleep'] == $b['asleep']) {
        return 0;
    }
    else if ($a['asleep'] < $b['asleep']){
        return 1;
    }
    else return -1;
}
uasort($guardtotals,"cmp_fun1");
$chosenguard = array_keys($guardtotals)[0];
$chosenminute = array_search(max($guardtotals[$chosenguard]['minutes']), $guardtotals[$chosenguard]['minutes']);
echo $chosenguard*$chosenminute;