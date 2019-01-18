<?php
/**
 * Created by PhpStorm.
 * User: mkl
 * Date: 07.01.2019
 * Time: 17:22
 */

/* Day 2: Inventory Management System */

$arrays= file("2_inputData.txt");

foreach ($arrays as $i=>$array) {
    if ($i != count($arrays)-1) {
        for ($x = $i+1; $x < count($arrays); $x++) {
            $idone = str_split($array);
            $idtwo = str_split($arrays[$x]);
            if (count(array_diff_assoc($idone, $idtwo)) == 1) { //array_diff_assoc: Computes the difference of arrays with additional index check
                echo implode("", array_intersect_assoc($idone, $idtwo));//array_intersect_assoc — Computes the intersection of arrays with additional index check

            }
        }
    }
}