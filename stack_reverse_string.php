<?php

include 'stack.php';

function reverse($str): string
{
    $i = 0;
    $stack = new Stack();

    while (@$str[$i] != null)
        $stack->push($str[$i++]);

    $temp = '';

    while (!$stack->isEmpty())
        $temp .= $stack->pop();

    return $temp;
}

print_r(reverse("ABCD"));
