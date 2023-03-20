<?php

function merge(array $arr_A, array $arr_B)
{
    $a_index = $b_index = 0;

    while($arr_A[ $a_index ] !== null && $arr_B[ $b_index ] !== null)
        $arr_C[ ] = ($arr_A[ $a_index ] < $arr_B[ $b_index ]) ? $arr_A[ $a_index++ ]
                                                              : $arr_B[ $b_index++ ];

    while($arr_A[ $a_index ] !== null)
        $arr_C[ ] = $arr_A[ $a_index++ ];

    while($arr_B[ $b_index ] !== null)
        $arr_C[ ] = $arr_B[ $b_index++ ];

    return $arr_C;
}

function merge_sort(array $arr)
{
    $lower_bound = 0;
    $upper_bound = count($arr) - 1;

    if ($lower_bound == $upper_bound)
        return [ $arr[$lower_bound] ];

    $mid = ($upper_bound + $lower_bound)/2;

    $left_side = array_slice($arr, 0, $mid + 1);
    $right_side = array_slice($arr, $mid + 1);

    $left_sorted = merge_sort($left_side);
    $right_sorted = merge_sort($right_side);

    return merge($left_sorted, $right_sorted);
}


$arr = [1, 4, 8, 5, 3, 11, 1122, 100, 9];
var_dump( merge_sort($arr) );

//var_dump( $arr );