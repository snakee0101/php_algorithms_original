<?php

function reverse($str)
{
    if($str == '')
        return '';

    return reverse( substr($str, 1) ) . $str[0];
}

var_dump( reverse('ABCD') );