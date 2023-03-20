<?php

function swap(&$value_1, &$value_2) //обмен элементов местами
{
    [$value_1, $value_2] = [$value_2, $value_1];
}

function selection_sort($input)
{
    $count = count($input);

    for ($outer_index = 0; $outer_index < $count; $outer_index++)  //обход массива вперед - собираем отсортированные элементы
    {
        $min_index = $count - 1; //инициализируем индекс наименьшего элемента - чтобы было с чем сравнивать

        for ($inner_index = $count - 1; $inner_index > $outer_index; $inner_index--)  //обход массива назад - ищем наименьший элемент СРЕДИ ОСТАВШИХСЯ (тех элементов, для которых $inner_index > $outer_index)
        {
            if($input[$inner_index] < $input[$min_index]) //если найденный элемент меньшего записанного - значит, он наименьший - сохраняем его индекс
                $min_index = $inner_index;
        }

        //если во внутреннем цикле нашли элемент меньший, чем первый из оставшихся - обмениваем их
        if( $input[$min_index] < $input[$outer_index] )
            swap($input[$min_index], $input[$outer_index]);
    }

    return $input;
}

$data = [7, 1, 8, 10, 12, 17, 11];
$data2 = [1, 2, 3];
$data3 = [4];

var_dump( selection_sort($data) );
var_dump( selection_sort($data2) );
var_dump( selection_sort($data3) );