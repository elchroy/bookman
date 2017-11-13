<?php

/**
 * [quick_sort description].
 *
 * @param array   $list The list to be sorted.
 * @param Closure $cb   The callback to apply during sorting.
 *
 * @return [type] The sorted list in ascending/descending order
 */
function quick_sort(array $list, Closure $cb) : array
{
    $len = count($list);
    if ($len <= 1) {
        return $list;
    } else {
        $pv = $list[0];
        $right = $left = [];
        for ($i = 1; $i < $len; $i++) {
            if ($cb($list[$i], $pv)) {
                $left[] = $list[$i];
            } else {
                $right[] = $list[$i];
            }
        }

        return array_merge(quick_sort($left, $cb), [$pv], quick_sort($right, $cb));
    }
}
