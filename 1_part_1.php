<?php
$frequency = 0;
$changes=file("1_inputData.txt");

foreach ($changes as $change) {
    $frequency += intval($change);
}
echo $frequency;






