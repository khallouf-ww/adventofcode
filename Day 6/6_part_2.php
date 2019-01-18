<?php
/**
 * Created by PhpStorm.
 * User: mkl
 * Date: 16.01.2019
 * Time: 13:59
 */

$input = file_get_contents("6_inputData.txt");
$coordinates = array_map(function($val) {
    $expl = explode(", ", $val);
    return array(
        'x' => intval($expl[0]),
        'y' => intval($expl[1])
    );
}, explode("\n", trim($input)));


function expandgrid() use ($grid,$coordinates,$size){
    global $grid;
    global $coordinates;
    global $size;

    $coordinates = array_map(function($val) {
        return array(
            'x' => $val['x']+1,
            'y' => $val['y']+1
        );
    }, $coordinates);

    for($i = 0; $i < count($grid); $i++) {
        for ($j = 0; $j < count($grid); $j++) {
            if ($i != 0 && $i != count($grid) && $j != 0 && $j != count($grid)) {
                continue;
            }
            $distances = null;
            $zone = null;
            $distances = array_map(function($x) {
                global $j;
                global $i;
                return (abs($i - $x['y']) + abs($j - $x['x']));
            }, $coordinates);
            if (array_sum($distances) < 10000) {
                $grid[$i][$j] = 1;
                $size += 1;
            }
        }
    }
}

$largest = array_reduce($coordinates, function($c, $i) {
    if ($c < $i['x']) {
        if ($i['x'] < $i['y']) {
            return $i['y'];
        }
        return $i['x'];
    }
    return $c;
}, 0);

for($i = 0; $i < $largest+1; $i++) {
    for ($j = 0; $j < $largest+1; $j++) {

        $distances = array_map(function($val) use ($i,$j) {

            return (abs($i - $val['y']) + abs($j - $val['x']));
        }, $coordinates);

        if (array_sum($distances) < 10000) {
            $grid[$i][$j] = 1;
            $size += 1;
        }
    }
}

do {
    echo "expanding grid : ";
    $edge_top = array_unique($grid[0]);
    $edge_bottom = array_unique($grid[count($grid)-1]);
    $edge_left = array_unique(array_column($grid, 0));
    $edge_right = array_unique(array_column($grid, 0));
    $edges = array_merge($edge_top, $edge_bottom, $edge_left, $edge_right);
    expandgrid();
} while(array_sum($edges) > 0);

echo $size;
