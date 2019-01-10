
/*Day 1: Chronal Calibration*/
<?php
$frequency  = 0;
$seen = array(0);
$currentk = 0;
$newfrequency = null;
$changes=file("1_inputData.txt");

do {
    if ($newfrequency) {
        array_push($seen, $newfrequency);//array_push — Push one or more elements onto the end of array
    }
    $frequency += intval($changes[$currentk]);//intval — Get the integer value of a variable
    $newfrequency = $frequency;
    $currentk++;

    if ($currentk == count($changes)) {
        $currentk = 0;
    }
} while (!in_array($newfrequency, $seen));
echo $frequency;




