<?php

function sum($n)
{
    return ($n == 1) ? 1
                     : sum($n - 1) + $n;
}

echo sum(10);