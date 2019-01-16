<?php
/**
 * Created by PhpStorm.
 * User: mkl
 * Date: 15.01.2019
 * Time: 12:28
 */


$input = file_get_contents("6_inputData.txt");
$coordinates = array_map(function($x) {
    $expl = explode(", ", $x);
    return array(
        'x' => intval($expl[0]),
        'y' => intval($expl[1])
    );
}, explode("\n", trim($input)));


function expandgrid() {
    global $grid;
    global $coordinates;

    $coordinates = array_map(function($x) {
        return array(
            'x' => $x['x']+1,
            'y' => $x['y']+1
        );
    }, $coordinates);

    for($i = 0; $i < count($grid); $i++) {
        for ($j = 0; $j < count($grid); $j++) {

            $distances = array_map(function($x) {
                global $j;
                global $i;
                return (($i - $x['y']) + ($j - $x['x']));
            }, $coordinates);

            $shortest = min($distances);
            $counts = array_count_values($distances);
            if ($counts[$shortest] > 1) {
                $grid[$i][$j] = 1;
                break;
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
        $distances = null;
        $zone = null;

        $distances = array_map(function($x) {
            global $j;
            global $i;
            return (abs($i - $x['y']) + abs($j - $x['x']));
        }, $coordinates);

        $shortest = min($distances);
        $counts = array_count_values($distances);
        if ($counts[$shortest] > 1) {
            $grid[$i][$j] = -1;
            continue;
        }
        $zone = array_search($shortest, $distances);
        $grid[$i][$j] = $zone;
        $zonesizes[$zone] += 1;
    }
}

$finalzones = $zonesizes;
$edge_top = array_unique($grid[0]);
$edge_bottom = array_unique($grid[count($grid)-1]);
$edge_left = array_unique(array_column($grid, 0));
$edge_right = array_unique(array_column($grid, 0));
$remove = array_values(array_unique(array_merge($edge_top, $edge_bottom, $edge_left, $edge_right)));

$finalzones = array_filter($finalzones, function($k) {
    global $remove;
    if (in_array($k, $remove)) {
        return 0;
    }
    return 1;
}, ARRAY_FILTER_USE_KEY);

echo max($finalzones);

