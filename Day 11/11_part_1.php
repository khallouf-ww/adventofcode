<?php
/**
 * Created by PhpStorm.
 * User: mkl
 * Date: 21.01.2019
 * Time: 15:46
 */

$input = 8444;
function calcPower($x, $y, $serialNumber) {
    $rackId = $x + 10;
    $powerLevel = $rackId * $y;   //  The power level start
    $powerLevel += $serialNumber; //  Adding the serial number produces
    $powerLevel *= $rackId;       //  Multiplying by the rack ID produces
    $powerLevel = ($powerLevel / 100) % 10; //  The hundreds digit
    return $powerLevel - 5;      // Subtracting 5 produces
}


$grid = [];
for ($y=1; $y <= 300; $y++) {
    for ($x=1; $x <= 300; $x++) {
        $grid[$y][$x] = calcPower($x, $y, $input);
    }
}

function getCoords($grid, $square = 3) {
    $maxPower = -INF;

    for ($size=3; $size <= $square; $size++) {
        for ($y=1; $y <= 300 - $size + 1; $y++) {
            $prevPower = NULL;
            for ($x=1; $x <= 300 - $size + 1; $x++) {
                $power = 0;

                if ($prevPower == NULL) {
                    for ($bottom=0; $bottom < $size; $bottom++) {
                        $power += $grid[$y + $bottom][$x];
                    }
                    for ($right=1; $right < $size; $right++) {
                        for ($bottom=0; $bottom < $size; $bottom++) {
                            $prevPower += $grid[$y + $bottom][$x + $right];
                        }
                    }
                    $power = $power + $prevPower;
                }
                else {
                    for ($bottom=0; $bottom < $size; $bottom++) {
                        $power += $grid[$y + $bottom][$x];
                    }
                    for ($bottom=0; $bottom < $size; $bottom++) {
                        $prevPower += $grid[$y + $bottom][$x + $size - 1];
                    }
                    $power = $prevPower;
                    $prevPower -= $power;
                }

                if ($power >= $maxPower) {
                    $maxPower = $power;
                    $maxX = $x;
                    $maxY = $y;

                }
            }
        }
    }
    $result = "(". $maxX . " , " . $maxY . ")";

    return $result;
}

echo "The X,Y coordinate of the top-left fuel cell of the 3x3 square with the largest total power: " . getCoords($grid);

