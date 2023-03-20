<?php

class LinkedListItem
{
    public $next;

    public function __construct(public $data,
                                public $key) { }
}

class SortedList
{
    public $first;

    public function isEmpty(): bool
    {
        return $this->first == null;
    }

    public function insert($data, $key) //insertion sort
    {
        $item = new LinkedListItem($data, $key);    //создадим вставляемый элемент

        $previous = null;           //храним предыдущий и текущий элемент (потому что вставляемый элемент должен попасть МЕЖДУ этими двумя элементами - поэтому нужно знать оба)
        $current = $this->first;    //начинаем с первого элемента

        while($current != null && $key > $current->key) // пока не дошли до конца И ключ вставляемого элемента больше текущего - перейдем к следующему элементу,
        {
            $previous = $current;
            $current = $current->next; // переходим к следующему элемету
        }   //А ЗАДАЧА ЦИКЛА - найти ПРАВИЛЬНЫЙ ПРЕДЫДУЩИЙ элемент, после которого будем вставлять созданный (потому что элемент вставляется относительно предыдущего - т.е. с помощью ссылки $previous->next)

        if($previous == null)   // если список пустой (нет предыдущего элемента)
            $this->first = $item;   //тогда вставляем элемент как первый
        else    // если список не пустой - предыдущий элемент, который нашли, должен указывать на вставляемый
            $previous->next = $item;

        $item->next = $current;  //а вставленный элемент тоже должен куда-то указывать - а именно на текущий элемент

        return $item;
    }

    public function getItemBefore($key) :LinkedListItem
    {
        $current_item = $this->first;

        while($current_item)
        {
            $next_item = $current_item->next;

            if($next_item->key == $key)  //Если следующий элемент относительно текущего - искомый - значит, мы нашли элемент
                return $current_item;

            $current_item = $current_item->next;
        }
    }

    public function last()
    {
        $last = $this->first;

        while( $last->next != null ) //найдем последний элемент
            $last = $last->next;

        return $last;
    }

    public function deleteLast() :LinkedListItem
    {
        $last = $this->last();

        if ($this->first->next == null) {   //если в списке только 1 элемент
            $this->first = null;
        } else {
            $previous = $this->getItemBefore($last->key);
            $previous->next = null; //предпоследний элемент станет последним - он не будет никуда указывать
        }

        return $last;   //вернем последний элемент
    }
}

class PriorityQueue
{
    private $items;

    public function __construct()
    {
        $this->items = new SortedList();
    }

    public function insert($data, $priority)
    {
        $this->items->insert($data, $priority); //данные сортируются автоматически самим списком
    }

    public function remove()
    {
        return $this->items->deleteLast()->data; //удаляем последний элемент - с наибольшим ключем
    }

    public function peek()
    {
        return $this->items->last()->data;
    }

    public function isEmpty()
    {
        return $this->items->isEmpty();
    }
}

class Product {
    public function __construct(public float $price) { }
}

$p1 = new Product(150);
$p2 = new Product(10);
$p3 = new Product(15);
$p4 = new Product(200);

$q = new PriorityQueue();

$q->insert($p1, $p1->price);
$q->insert($p2, $p2->price);
$q->insert($p3, $p3->price);
$q->insert($p4, $p4->price);

$q->remove();
$q->remove();
$q->remove();

$q->remove();

$q->insert(44, 44);

var_dump( $q->remove() );
