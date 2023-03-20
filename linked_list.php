<?php

class LinkedListItem
{
    public $next;

    public function __construct(public $data,
                                public $key) { }
}

class LinkedList
{
    public $first;

    public function __construct() { }

    public function isEmpty(): bool
    {
        return $this->first == null;
    }

    public function insertFirst($data, $key = null)
    {
        if( $this->find($key) )
            throw new Exception('Item with such key already exists');

        $key ??= rand();    //если ключ не задан явно - создадим его автоматически
        $item = new LinkedListItem($data, $key);    //при создании элемента списка нужно задать ключ

        /*
         * Вставляемый элемент должен указывать на тот, который раньше был первым
         * */
        $item->next = $this->first;

        /*
         * Первый элемент списка (он хранится как поле $first списка) должен указывать на вставляемый.
         * */
        $this->first = $item;

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

    public function insertAfter($after_key, $data, $key = null)
    {
        if( $this->find($key) )
            throw new Exception('Item with such key already exists');

        $key ??= rand();    //если ключ не задан явно - создадим его автоматически
        $item = new LinkedListItem($data, $key);    //при создании элемента списка нужно задать ключ

        $after = $this->find( $after_key ); //найдем элемент, после которого вставляем

        /*
         * элемент, который вставляем, должен указывать на следующий
         * элемент относительно того элемента, после которого вставляем
         * */
        $item->next = $after->next;

        /*
         * а вот элемент, после которого вставляем, должен указывать на
         * элемент, который вставляем
         * */
        $after->next = $item;

        return $item;
    }

    public function insertLast($data, $key = null)
    {
        if( $this->find($key) )
            throw new Exception('Item with such key already exists');

        $key ??= rand();    //если ключ не задан явно - создадим его автоматически

        $item = new LinkedListItem($data, $key);    //при создании элемента списка нужно задать ключ


        if($this->first == null)
            return $this->insertFirst( $data, $key );

        $last_item = $this->first;

        while($last_item?->next != null) //найдем последний элемент
            $last_item = $last_item->next;

        $last_item->next = $item;    //вставим элемент после последнего

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