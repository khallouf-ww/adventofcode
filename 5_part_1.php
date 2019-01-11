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
    $nextValue= $plymer[$i+1];

    if  ( $value == strtoupper($nextValue)  || ($value == strtolower($nextValue) )) {

        array_splice($polymer,$i,2);
      //  $str = substr_replace($polymer, '', $i, 2);


    }
    elseif  (strtoupper($value)  == $nextValue  || ( strtolower($value) == $nextValue )) {

        array_splice($polymer, $i, 2);
    }

}

echo count($polymer);



