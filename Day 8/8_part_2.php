<?php
/**
 * Created by PhpStorm.
 * User: mkl
 * Date: 18.01.2019
 * Time: 11:53
 */

$input = file_get_contents("8_inputData.txt");
$numOfNode = array_map(function($x) {
    return intval($x);
}, explode(" ", $input));

$position = 0;
$meta_entries = array();
$rootNode = array();

function get_children($c) {
    global $numOfNode;
    global $position;

    $childNodes = array();
    $count = 0;
    $position += 2;

    while ($count < $c && $position < count($numOfNode)) {
        $children = $numOfNode[$position];
        $metaCount = $numOfNode[$position+1];

        array_push($childNodes, array(
            'childCount' => $children,
            'metaCount' => $metaCount,
            'children' => array(),
            'meta' => array(),
            'value' => 0
        ));

        if ($children > 0) {
            $childNodes[$count]['children'] = get_children($children);
        } else {
            $position += 2;
        }

        if ($metaCount > 0) {
            $childNodes[$count]['meta'] = array_slice($numOfNode, $position, $metaCount);
            if ($childNodes[$count]['childCount'] == 0) {
                $childNodes[$count]['value'] = array_sum($childNodes[$count]['meta']);
            } else {
                foreach ($childNodes[$count]['meta'] as $m) {
                    if (array_key_exists($m-1, $childNodes[$count]['children'])) {
                        $childNodes[$count]['value'] += $childNodes[$count]['children'][$m-1]['value'];
                    }
                }
            }
            $position += $metaCount;
        }
        $count++;
    }
    return $childNodes;
}

$children = $numOfNode[$position];
$metacount = $numOfNode[$position+1];

array_push($rootNode, array(
    'childCount' => $children,
    'metaCount' => $metacount,
    'children' => array(),
    'meta' => array(),
    'value' => 0
));

if ($children > 0) {
    $rootNode[0]['children'] = get_children($children);
} else {
    $position += 2;
}

if ($metacount > 0) {
    $rootNode[0]['meta'] = array_slice($numOfNode, $position, $metacount);
}

if ($rootNode[0]['childCount'] == 0) {
    $rootNode[0]['value'] = array_sum($rootNode['meta']);
} else {
    foreach ($rootNode[0]['meta'] as $i=> $m) {
        if (array_key_exists($m-1, $rootNode[0]['children'])) {
            $rootNode[0]['value'] += $rootNode[0]['children'][$m-1]['value'];
        }
    }
}
echo "The value of the root node is : " . $rootNode[0]['value'];