<?php

function knapsack(array $weights, int $target)
{
    foreach ($weights as $weight) //выберем 1-й элемент (каждый элемент может быть первым)
    {
        if ($weight == $target) { //задача решена, если масса текущего элемента равна необходимой - base case
            return [$weight]; //тогда вернуть эту массу (заворачиваем её в массив, потому что при рекурсии вложенность массивов будет накапливаться)
        }

        if ($weight > $target)   //если масса оказалась больше или остался последний элемент - переходим к следующему элементу (прерываем рекурсию)
            continue;

        //накапливаем общую массу элементов, которые запомнили
        //если задача не решена - тогда запоминаем текущий элемент,

        $last_weight = knapsack(
            array_diff($weights, [$weight]), //исключаем текущий элемент из выборки, (таким образом, уменьшая размер проблемы)
            $target - $weight //общую массу уменьшаем на массу текущего элемента, и повторяем операцию
        );

        if($last_weight) //необходимо вернуть результат по цепочке вызовов, если подсчет успешный (т.е. если мы нашли нужный последний элемент, и вернули его - тогда он равен НЕ NULL)
            return [$weight, ...$last_weight];  //накапливаем текущую массу и последнюю массу (набор последних масс), которую вернули
            //поскольку при выходе на более высокий уровень возвращаются массивы - то уменьшаем их уровень вложенности, распаковывая возвращаемый массив ($last_weight) и добавляя к нему текущий элемент ($weight)
            //даже если $last_weight - это единственный элемент (самый глубокий уровень вложенности) - мы тоже можем его распаковать - потому что один элемент тоже заворачивается в массив
    }
}


//var_dump( array_diff([11, 8, 7, 6, 5], [7]) );

//var_dump(  );

var_dump(knapsack([11, 8, 7, 6, 5], 20));
var_dump(knapsack([11, 8, 7, 6, 5], 20));