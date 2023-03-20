<?php

function needs_sorting(array $input) :bool
{
    $needs_sorting = false;

    foreach ($input as $key => &$first_item)   //loop through pairs of items
    {
        if(@$input[$key + 1] == null)
            break;

        if ($first_item > $input[$key + 1])
            $needs_sorting = true;
    }

    return $needs_sorting;
}

function swap(&$value_1, &$value_2) //обмен элементов местами
{
    [$value_1, $value_2] = [$value_2, $value_1];
}

function _sort(&$input)
{
    foreach ($input as $key => &$first_item)   //пройтись по всем элементам (точнее, берем пары элементов)
    {
        if(@$input[$key + 1] == null) //если второй элемент пары не существует - прервать сортировку
            break;

        if ($first_item > $input[$key + 1])  //если первый элемент в паре больше второго - обменять их местами
            swap($input[$key], $input[$key + 1]);
    }
}

function bubble_sort(array $input)
{
    while(needs_sorting($input))
        _sort($input);

    return $input;
}

$input = [7, 6, 4, 3, 1, 2]; //1, 2, 3, 4, 6, 7
$input2 = [1, 2, 3]; //1, 2, 3, 4, 6, 7

var_dump( bubble_sort($input) );
var_dump( bubble_sort($input2) );