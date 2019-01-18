<?php
/**
 * Created by PhpStorm.
 * User: mkl
 * Date: 17.01.2019
 * Time: 10:58
 */
$input = file_get_contents("8_inputData.txt");
$numOfNode = array_map(function($x) {
    return intval($x);
}, explode(" ", $input));
$position = 0;
$meta_entries = array();

function get_children($c) {
    global $numOfNode;
    global $position;
    global $meta_entries;

    $count = 0;
    $position += 2;

    while ($count < $c && $position < count($numOfNode)) {
        $n_childs = $numOfNode[$position];
        $n_metaData = $numOfNode[$position+1];

        if ($n_childs > 0) {
            get_children($n_childs);
        } else {
            $position += 2;
        }

        if ($n_metaData > 0) {
            $meta_entries = array_merge($meta_entries, array_slice($numOfNode, $position, $n_metaData));
            $position += $n_metaData;
        }
        $count++;
    }
    return ;
}
for ($position;  $position < count($numOfNode) ;$position++ ){

    $children = $numOfNode[$position];
    $metaCount = $numOfNode[$position+1];
    if ($children > 0) {
        get_children($children);
    }
    else {
        $position += 2;
    }

    if ($metaCount > 0) {
        $meta_entries = array_merge($meta_entries, array_slice($numOfNode, $position, $metaCount));
        $position += $metaCount;
    }
}

echo "The sum of all metadata entries is : " . array_sum($meta_entries);