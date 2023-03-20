<?php

function factorial($n)
{
    return ($n == 0) ? 1  //база индукции
                     : factorial($n - 1) * $n;   //индукционный переход
}

echo factorial(4);