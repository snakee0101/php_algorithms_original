<?php

include "linked_list.php";

class Stack
{
    private $items; //хранить указатель на верхний элемент не нужно - это сделает связанный список

    public function __construct()
    {
        $this->items = new LinkedList();    //инициализируем связанный список для хранения элементов при создании стека
    }

    public function push($data)
    {
        return $this->items->insertFirst( $data );  //в стеке ключи не важны
    }

    public function pop()
    {
        return $this->items->deleteFirst();
    }

    public function peek()
    {
        return $this->items->first;
    }

    public function isEmpty()
    {
        return $this->items->isEmpty();
    }
}

var_dump(PHP_INT_MIN);

$stack = new Stack();

$stack->push( 12 );
$stack->push( 'test' );
$stack->push( 'NEXT' );
//$stack->push( 'hjghj' );
//$stack->push( 700 );

$stack->pop();

//var_dump( $stack );
//$stack->pop( );
//$stack->push( 'str' );

var_dump( $stack );

//var_dump( $stack );