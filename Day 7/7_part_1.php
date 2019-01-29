<?php
/**
 * Created by PhpStorm.
 * User: mkl
 * Date: 29.01.2019
 * Time: 11:45
 */
$input = file_get_contents("7_inputData.txt");
$instructions = explode("\n", $input);
$steplist = str_split('ABCDEFGHIJKLMNOPQRSTUVWXYZ');
$steps = array();
$after = array();
foreach ($steplist as $s) {
    $after[$s] = array();
}
foreach ($instructions as $inst) {
    preg_match('~Step ([A-Z]) must be finished before step ([A-Z]) can begin.~', $inst, $stepnames);
    array_push($after[$stepnames[2]], $stepnames[1]);
}

foreach($steplist as $i=>$step) {
    if (count($after[$step]) == 0) {
        array_push($steps, $step);
        unset($after[$step]);

        while (count($after)) {

            $next_candidates = array_filter($after, function($v)  {
                global $steps;
                if (array_intersect($v, $steps) == $v) {
                    return true;
                }
                return false;
            });

            ksort($next_candidates);
            if ($next_candidates) {
                $next = array_keys($next_candidates)[0];
                array_push($steps, $next);
                unset($after[$next]);
            } else {
                break;
            }
        }
        break;
    }
}

echo join("", $steps);