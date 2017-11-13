<?php

namespace Tests\Unit;

use TestCase;

class HelpersTest extends TestCase
{
    public function testQuickSortHelperCanSortNumbersInAscendingOrder()
    {
        $unsortedIntergerArray = [2, -9, 78, 9, -87];
        $sortedArray = [-87, -9, 2, 9, 78];
        
        $result = quick_sort($unsortedIntergerArray, function (int $num, int $pivot) : bool {
            return $num <= $pivot;
        });

        $this->assertEquals($sortedArray, $result);
    }
}