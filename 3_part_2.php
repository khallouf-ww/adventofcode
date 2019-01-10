<?php
/**
 * Created by PhpStorm.
 * User: mkl
 * Date: 08.01.2019
 * Time: 15:39
 */

/*  Day 3: No Matter How You Slice It*/


$claims= file("3_inputData.txt");
$fabric = array_fill(0, 1000, array_fill(0, 1000, 0));

foreach($claims as $j=>$claim) {
    preg_match('/\#([0-9]+) \@ ([0-9]+),([0-9]+): ([0-9]+)x([0-9]+)/', $claim, $data);
    $claims[$j] = $data;
    $c = $data[1];
    $x = intval($data[2]);
    $y = intval($data[3]);
    $w = intval($data[4]);
    $h = intval($data[5]);

    for ($i = $y; $i < $y+$h; $i++) {
        $slice = array_slice($fabric[$i], $x, $w);
        $slice = array_map(function($x) {
            return $x+1;
        }, $slice);
        array_splice($fabric[$i], $x, $w, $slice);
    }
}

foreach ($claims as $claim) {
    $c = $claim[1];
    $x = $claim[2];
    $y = $claim[3];
    $w = $claim[4];
    $h = $claim[5];

    $arr = array();

    for ($i = $y; $i < $y+$h; $i++) {
        $slice = array_slice($fabric[$i], $x, $w);
        array_push($arr, array_product($slice));
    }

    if (array_product($arr) == 1) {
        echo $c;
        break;
    }
}