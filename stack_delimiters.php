<?php

class Stack
{
    private array $items;
    private int $top = -1;

    public function push($data)
    {
        $this->items[ ++$this->top ] = $data;
    }

    public function pop() :mixed
    {
        if($this->top == -1)
            return null;

        return $this->items[ $this->top-- ];
    }

    public function peek() :mixed
    {
        return $this->items[$this->top] ?? null;
    }

    public function isEmpty() :bool
    {
        return $this->top == -1;
    }
}

function delimiter_matches($stack, $char) :bool
{
    $opposite = match($char) {
        '}' => '{',
        ')' => '(',
        ']' => '[',
        default => null
    };

    return $stack->peek() == $opposite;
}

function is_closing_delimiter($char) :bool
{
    return match($char) {
        '}', ')', ']' => true,
        default => false
    };
}

function check($str) :bool
{
    $i = 0;
    $stack = new Stack();

    while( @$str[$i] != null ) //разбираем строку по одному символу
    {
        switch($str[$i]) //проверяем этот символ на наличие открывающей скобки
        {
            case '{':
            case '[':
            case '('://найшли открывающую скобку
                $stack->push( $str[$i] ); //- добавили в стек
        }

        //если символ - это закрывающая скобка
        if( is_closing_delimiter($str[$i]) )
        {
            if( !delimiter_matches($stack, $str[$i]) ) //и если она НЕ соответствует открывающей скобке из стека
                return false; //возвращаем соотвествующий статус, что выражение неверно (false)

            $stack->pop(); //если же скобка соотвествует - удаляем открывающую скобку из стека
        }

        $i++;
    }

    return $stack->isEmpty();  //если стек пустой - значит, выражение правильное - все скобки соответствуют друг другу
}

$stack = new Stack();

var_dump( check('4[uiu(55uiu5)i]') );  //правильно - true
var_dump( check('4[uiu[55u]iu(5)i]') ); //правильно - true
var_dump( check('4[uiu(55uiu5i]') ); //неправильно - false
var_dump( check('4[uiu55uiu5)i]') ); //неправильно - false