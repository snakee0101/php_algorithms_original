<?php

class Node
{
    public function __construct(public int $frequency,
                                public     $symbol = null,
                                public     $left_child = null,
                                public     $right_child = null)
    {

    }
}

function frequency_table($str)
{
    $i = 0; $counts = [];

    while ($str[$i] != null)
    {
        @$counts[ $str[$i] ]++;
        $i++;
    }

    asort($counts); //сортировка с сохранением ключей

    return $counts;     //[ "m" => 4, "e" => 6, " " => 12, ... ]
}

function generate_leaf_nodes($frequency_table) //генерирует узлы-листья для каждого символа
{
    $nodes = [];

    foreach ($frequency_table as $symbol => $frequency)
        $nodes[ ] = new Node($frequency, $symbol);

    return $nodes;
}

function huffman_tree($leaf_nodes) //передаем массив с узлами-листьями
{
    //начнем с первых двух узлов
    $new_root = new Node($leaf_nodes[0]->frequency + $leaf_nodes[1]->frequency, null, $leaf_nodes[0], $leaf_nodes[1]);

    $i = 2; //начнем с 3-го узла
    while ( $leaf_nodes[ $i ] != null)   //пока следующий узел-лист существует - вставляем узлы-листья в дерево
    {
        //обьединяем два узла-листа (прошлый $new_root и текущий $nodes[ $i ]) общим узлом-корнем $new_root в правильном порядке
        $new_root = $new_root->frequency < $leaf_nodes[$i]->frequency ? new Node($new_root->frequency + $leaf_nodes[$i]->frequency, null, $new_root, $leaf_nodes[$i])
                                                                      : new Node($new_root->frequency + $leaf_nodes[$i]->frequency, null, $leaf_nodes[$i], $new_root);
        //если частота нового узла ($new_root->frequency) меньше, чем следующего ($leaf_nodes[$i]->frequency) - он станет левым, а если больше - правым
        $i++;
    }

    return $new_root;   //возвращаем узел-корень дерева
}

function flatten(array $array)  //нужно, чтобы избавиться от всех вложенных элементов, получаемых при работе huffman_codes_table(). Применение: $codes_table = flatten( huffman_codes_table($tree_root) );
{
    $return = [];

    array_walk_recursive($array, function($a, $key) use (&$return) { $return[$key] = $a; });

    return $return;
}

//$prev_bit_sequence - накапливаем последовательность битов, из которых складываем код для символа (из-за рекурсивного вызова)
function huffman_codes_table($node, $prev_bit_sequence = "")    //рекурсивно обойдем дерево, начиная с корня, и соберем код Хаффмана для ОДНОГО СИМВОЛА
{
    if($node->symbol != null)   //если дошли до последнего узла с символом
        return [ $node->symbol => $prev_bit_sequence ]; //- возвращаем код для данного символа (накопленная последовательность битов)

    //каждый раз погружаемся на один узел глубже - как для правого, так и для левого узла
    if($node->left_child != null)    //если этот узел существует
        $symbols[] = huffman_codes_table($node->left_child, $prev_bit_sequence . 0);  //для левого узла впереди последовательности битов добавляем 0

    if($node->right_child != null)
        $symbols[] = huffman_codes_table($node->right_child, $prev_bit_sequence . 1); //для правого узла - 1

    return $symbols; //$symbols[] - сохраняем последовательность накопленных символов
}

function encode($str)   //закодируем строку и вернем дерево символов - по нему будет происходить раскодировка
{
    $fr_table = frequency_table($str);
    $nodes = generate_leaf_nodes($fr_table);

    $tree_root = huffman_tree( $nodes );
    $codes_table = flatten( huffman_codes_table($tree_root) );

    $encoded = '';

    $i = 0;
    while($str[$i] != null)
    {
        $encoded .= $codes_table[ $str[$i] ];  //для кодирования строки нужно подставить вместо соответствующего символа его код из таблицы
        $i++;
    }

    return [$encoded, $tree_root];        //без дерева с символами раскодировать строку нельзя - дерево нужно возвращать вместе с закодированной строкой
}

//переход к следующему узлу (в глубину дерева)
function _next($tree_node, $bit)    //$bit - 0 или 1 - обозначает один бит
{
    return ($bit == '1') ? $tree_node->right_child
                         : $tree_node->left_child; //если 1 - переходим вправо (возвращаем правый дочерний элемент), 0 - влево
}

function decode($str, $root_node)
{
    $temp = '';

    $i = 0;
    $node = $root_node; //начинаем обход с корневого узла

    while ($str[$i] != null)    //обходим закодированную строку по одному "биту" ($str[$i] - текущий бит - символ 0 или 1)
    {
        $node = _next($node, $str[$i]); //переходим к узлу, соответствующему данному "биту" (в данном случае символа 0 или 1) - потому что изначально мы находились на корневом узле (который не соответствует ни одному биту)

        if($node?->symbol != null) //если к узлу привязан символ - значит символ раскодирован
        {
            $temp .= $node->symbol; //- записываем его в строку
            $node = $root_node;   //сбрасываем текущий узел, чтобы можно было снова начать с корневого узла
        }

        $i++; //переходим к следующему символу
    }

    return $temp;
}


$data = encode('ABBCCCD');

//var_dump( $data );

var_dump( decode($data[0], $data[1]) );