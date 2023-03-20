<?php

/**
* $topN - номер перекладываемого диска (считаем сверху вниз: 1 (верхний), 2, 3 (нижний))
* $from, $intermediate, $to - названия палочек
* $from - откуда перекладываем
* $intermediate - промежуточная
* $to - куда перекладываем
*/
function doTowers($topN, $from, $intermediate, $to)
{
    if($topN == 1) {
        echo "Move disc 1 from $from to $to\n";     //[шаг 2 алгоритма] самый последний диск можно реально переместить
    } else {
        doTowers($topN - 1, $from, $to, $intermediate);  //[шаг 1 алгоритма] все оставшиеся N - 1 дисклв - на промежуточную площадку ($from -> $intermediate)

        echo "Move disc $topN from $from to $to\n";  //самый нижний диск - на конечную площадку

        doTowers($topN - 1, $intermediate, $from, $to); //[шаг 3 алгоритма] все оставшиеся N - 1 дисклв - с промежуточной площадки на конечную ($intermediate -> $to)
    }
}

doTowers(3, 'A', 'B', 'C');