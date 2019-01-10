<?php
/**
 * Created by PhpStorm.
 * User: mkl
 * Date: 07.01.2019
 * Time: 14:59
 */

/* Day 2: Inventory Management System */
$twos = 0;
$threes = 0;
$arrays= file("Aufgabe2");

foreach ($arrays as $array) {
    $letters = str_split($array);// convert str to an array
    $values = array_values(array_count_values($letters)); //array_values — return all values of arr and indexes!
    if (in_array(2, $values)) { // Checks if a value exists in an array
        $twos++;
    }
    if (in_array(3, $values)) {
        $threes++;
    }
}
echo $twos*$threes;