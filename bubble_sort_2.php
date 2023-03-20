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
    $count = count($input);

    for ($out = $count - 1; $out > 1; $out--)    //внешний цикл – перемещаемся назад (с каждым отсотированным элементом исключаем его из сортировки – перемещаемся назад на одну позицию)
        for ($in = 0; $in < $out; $in++)    //внутренний цикл – перемещаемся вперед – сдвигаем текущий элемент в конец списка при необходимости (но не подходим к элементам в конце списка – они уже отсортированы)
            if($input[$in] > $input[$out])  //если элементы в неправильном порядке
                swap($input[$in], $input[$out]);    //меняем их местами
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