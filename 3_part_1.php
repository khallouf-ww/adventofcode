
<?php
/**
 * Created by PhpStorm.
 * User: mkl
 * Date: 08.01.2019
 * Time: 11:56
 */
/*  Day 3: No Matter How You Slice It*/

$claims= file("3_inputData.txt");
$fabric = array_fill(0, 1000, array_fill(0, 1000, 0)); //array_fill — Fill an array with values
foreach($claims as $claim) {
    preg_match('/\#[0-9]+ \@ ([0-9]+),([0-9]+): ([0-9]+)x([0-9]+)/', $claim, $data);//preg_match — Perform a regular expression match
    $x = intval($data[1]);//intval — Get the integer value of a variable
    $y = intval($data[2]);
    $w = intval($data[3]);
    $h = intval($data[4]);


    for ($i = $y; $i < $y+$h; $i++) {
        $slice = array_slice($fabric[$i], $x, $w); //array_slice() returns the sequence of elements from the array, array as specified by the offset and length parameters.

        $slice = array_map(function($x) {
                             return $x+1;
                             } , $slice);

        array_splice($fabric[$i], $x, $w, $slice);  //array_splice — Remove a portion of the array and replace it with something else

    }
}

$twoplus = 0;

foreach ($fabric as $row) {
    $claimcounts = array_count_values($row);
    foreach ($claimcounts as $val=>$count) {
        if ($val >= 2) {
            $twoplus += $count;
        }
    }
}
echo $twoplus;
