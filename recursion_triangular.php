<?php

function triangular($n)
{
    return ($n == 1) ? 1
                     : triangular($n - 1) + $n;
}

echo triangular(4);