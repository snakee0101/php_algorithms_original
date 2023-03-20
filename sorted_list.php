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

    public function __construct() { }

    public function isEmpty(): bool
    {
        return $this->first == null;
    }

    /*public function insert($data, $key)
    {
        if( $this->find($key) )
            throw new Exception('Item with such key already exists');

        $item = new LinkedListItem($data, $key);

        //найдем позицию, куда вставлять элемент - будем учитывать текущий элемент - с помощью него определим, где мы находимся в списке
        $current = $this->first;    //начнем с первого элементп

        if ($current == null) //СЛУЧАЙ 1 - если список      ПУСТОЙ
            return $this->first = $item;    //- сразу вставляем элемент на первую позицию

        while( $current ) //обойдем все элементы
        {
            if( ($current == $this->first) && ($key < $this->first->key) )  //СЛУЧАЙ 2 - если находимся на    ПЕРВОМ     элементе И ключ вставляемого элемента меньше, чем первого - тогда вставляемый элемент станет первым
            {
                $item->next = $current;
                $this->first = $item;

                break;
            }

            if( $current->next == null ) //СЛУЧАЙ 3 - Если элемент еще не вставлен, а мы уже на     ПОСЛЕДНЕМ     элементе ($current->next == null) - тогда вставляем на последнюю позицию
            {
                $current->next = $item;

                break;
            }

            if( $key > $current->key && $key < $current->next->key) //СЛУЧАЙ 4 - если мы находимся в   СЕРЕДИНЕ   списка и попалась подходящая позиция (проверяем по текущему и следующему элементу - вставляемый элемент должен быть МЕЖДУ ними) - вставляем элемент
            {
                $item->next = $current->next;
                $current->next = $item;

                break;
            }

            $current = $current->next;  //переходим к следующему элементу
        }

        return $item;
    }*/

    public function insert($data, $key) //insertion sort
    {
        if( $this->find($key) )
            throw new Exception('Item with such key already exists');

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

    public function delete($key)
    {
        /**
         * сначала найдем элемент, предыдущий относительно удаляемого
         * */
        $item_before = $this->getItemBefore($key);
        $item = $item_before->next; //удаляемый элемент - это следующий

        /**
         * предыдущий элемент должен указывать на следующий относительно удаляемого элемента
         * */
        $item_before->next = $item->next;

        return $item;
    }

    public function deleteFirst() :LinkedListItem
    {
        $item = $this->first;
        /*
         * Ссылка на первый элемент теперь должна указывать на второй
         * */
        $this->first = $this->first->next;

        return $item;
    }

    public function find($key) :?LinkedListItem
    {
        $item = $this->first; //начнем обход с первого элемента

        while($item) //пока существует следующий элемент (обходим все элементы)
        {
            if($item->key == $key) //если нашли элемент (для этого данные элемента ($key) должны совпадать)
                return $item; //возвращаем его и выходим из цикла

            $item = $item->next ?? null; //переход к следующему элементу, если он существует
        }

        return null; //если элемент не найден - вернем null
    }
}

$list = new SortedList();

$list->insert(50, 50);
$list->insert(80, 80);
$list->insert(70, 70);
$list->insert(10, 10);
$list->insert(90, 90);
$list->insert(100, 100);

var_dump( $list );