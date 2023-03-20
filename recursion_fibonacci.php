<?php


function fib($n)
{
    return $n == 1 || $n == 2 ? 1        //база индукции - первые два числа - это 1
                              : fib($n - 1) + fib($n - 2);        //согласно формуле
}

var_dump( fib(8) );