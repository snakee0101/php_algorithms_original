<?php

function find(array $items, $search) :?int
{
    $lowerBound = 0;
    $upperBound = count($items) - 1;
    $curIn = null;

    while (true) {
        $curIn = ($lowerBound + $upperBound) / 2; //текущий элемент
        if ($items[$curIn] == $search)
            return $curIn;   //нашли элемент - вернуть его
        else if ($lowerBound > $upperBound)
            return null;  //элемент не найден
        else { // поделить поисковый диапазон наполовину
            if ($items[$curIn] < $search)
                $lowerBound = $curIn + 1; // элемент находится в верхней половине - отбрасываем нижнюю половину
            else
                $upperBound = $curIn - 1; // элемент находится в нижней половине - отбрасываем верхнюю половину
        }
    }
}

var_dump( find([1, 20, 3, 40, 70, 80, 100], 70) );  //: 4