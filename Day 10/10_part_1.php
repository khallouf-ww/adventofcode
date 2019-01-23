<?php
/**
 * Created by PhpStorm.
 * User: mkl
 * Date: 18.01.2019
 * Time: 14:51
 */


$input = file("10_inputData.txt") ;

$array = array_map(function($str) {
    $regex = "~position=<\s?(-?\d+),\s+(-?\d+)>\svelocity=<\s?(-?\d+),\s+(-?\d+).+~";
    return preg_split($regex, $str,NULL , PREG_SPLIT_NO_EMPTY | PREG_SPLIT_DELIM_CAPTURE );
}, $input);


function calcMinHeight($array) {
    $min = INF;
    $max = 0;

    foreach ($array as $value) {
        if ($value[0] < $min) {

            $min = $value[0];
        }
        if ($value[0] > $max) {
            $max = $value[0];
        }
    }
    return $max - $min;
}

function calcPosition($array, $seconds) {
    return array_map(function($array) use($seconds) {
        $posX = $array[0] + ($array[2] * $seconds);
        $posY = $array[1] + ($array[3] * $seconds);
        return [$posX, $posY];
    }, $array);
}


$positions = [];
$height = INF;
$seconds = 1;

while (true) {
    $positions = calcPosition($array, $seconds);
    $newHeight = calcMinHeight($positions, $height);

    if ($newHeight > $height) {
        $seconds--;
        $positions = calcPosition($array, $seconds);
        break;
    } else {
        $height = $newHeight;
        $seconds++;
    }
}

$pixels = [];
foreach ($positions as $value) {
    $pixels[$value[0]][$value[1]] = true;
}

foreach ($positions as $value) {
    if ($value[0] > $maxX) {
        $maxX = $value[0];
    }
    if ($value[0] < $minX) {
        $minX = $value[0];
    }
    if ($value[1] > $maxY) {
        $maxY = $value[1];
    }
    if ($value[1] < $minY) {
        $minY = $value[1];
    }
}

for ($y=$minY ; $y <= $maxY ; $y++) {
    for ($x=$minX ; $x <= $maxX ; $x++) {
        echo !empty($pixels[$x][$y]) ? "#" : "~";
    }
    echo "\n";
}