<?php
/**
 * Created by PhpStorm.
 * User: mkl
 * Date: 11.01.2019
 * Time: 10:19
 */

$polymer= file("5_inputData.txt");

for ($i=0; $i < count($polymer)-1 ;$i++){
    $value= $polymer[$i];
    $nextValue= $polymer[$i+1];

    if ( (strtolower($value) == strtoupper($nextValue) ) || (strtoupper($value) == strtolower($nextValue) ) ){

          array_splice($polymer,$i,2);
      //  $str = substr_replace($polymer, '', $i, 2);
    }
}

echo count($polymer);

