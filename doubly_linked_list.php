<?php

class DoublyLinkedListItem
{
    public ?self $next, //ссылка на следующий элемент
                 $prev; //ссылка на предыдущий элемент

    public function __construct(public $key,
                                public $data) { }
}

class DoublyLinkedList
{
    public ?DoublyLinkedListItem $first = null,   //первый элемент списка
                                 $last = null;    //последний элемент списка

    public function find($key) :?DoublyLinkedListItem   //такая же процедура, как и в LinkedList
    {
        $item = $this->first;

        while($item)
        {
            if($item->key == $key)
                return $item;

            $item = $item->next ?? null;
        }

        return null;
    }

    public function isEmpty(): bool
    {
        return $this->first == null;
    }

    public function insertFirst($data, $key = null) :DoublyLinkedListItem
    {
        if( $this->find($key) )
            throw new Exception('Item with such key already exists');

        $key ??= rand();    //если ключ не задан явно - создадим его автоматически

        $item = new DoublyLinkedListItem($data, $key);    //при создании элемента списка нужно задать ключ

        $item->next = $this->first; //вставляем элемент на первую позицию
        $item->prev = null;

        if( $this->isEmpty() ) //если список пустой
            $this->last = $item;    //- то первый и последний элемент - это одно и то же
        else    //но если список не пустой
            $this->first->prev = $item; // - то старый первый элемент указывает (->prev) на вставляемый

        $this->first = $item; //вставляем элемент на первую позицию

        return $item;
    }

    public function insertAfter($after_key, $data, $key = null) :DoublyLinkedListItem
    {
        if( $this->find($key) )
            throw new Exception('Item with such key already exists');

        $key ??= rand();    //если ключ не задан явно - создадим его автоматически

        $inserted = new DoublyLinkedListItem($data, $key);    //при создании элемента списка нужно задать ключ
        $after = $this->find($after_key);   //найдем элемент, после которого вставлять

        $inserted->next = $after->next;     //переставим элемент в нужном порядке

        if ($after->next != null)    //если элемент не последний
            $inserted->next->prev = $inserted;  //- устанавливаем ссылку ->prev следующего элемента (потому что после последнего элементов не существует)

        $inserted->prev = $after;
        $after->next = $inserted;

        return $inserted;
    }

    public function insertLast($data, $key = null) :DoublyLinkedListItem
    {
        $item = $this->isEmpty() ? $this->insertFirst($data, $key) //если список пустой - обработаем отдельно
                                 : $this->insertAfter(after_key: $this->last->key, data: $data, key: $key);  //а если список не пустой - вставим элемент после последнего

        return $this->last = $item;    //обязательно нужно перезаписать указатель на последний элемент (можно одновременно вернуть вставленный элемент)
    }

    public function deleteFirst() :DoublyLinkedListItem
    {
        $deleted = $this->first;

        $this->first = $this->first->next;
        $this->first->prev = null;

        return $deleted;
    }

    public function deleteLast() :DoublyLinkedListItem
    {
        $deleted = $this->last;

        $this->last = $this->last->prev;
        $this->last->next = null;

        return $deleted;
    }

    public function delete($key) :DoublyLinkedListItem
    {
        $deleted = clone $this->find($key); //clone нужен, чтобы не произошло "короткого замыкания" ссылок

        if ($deleted == $this->first)       //можно обработать случай, если удаляем первый или последний элемент - для этого нужна другая процедура
            return $this->deleteFirst();
        elseif ($deleted == $this->last)
            return $this->deleteLast();

        $deleted->prev->next = $deleted->next;  //предыдущий элемент должен указывать на следующий
        $deleted->next->prev = $deleted->prev;  //а следующий — на предыдущий

        return $deleted;
    }
}


$list = new DoublyLinkedList();


$list->insertFirst(50, 50);
$list->insertFirst(20, 20);
$list->insertLast(70, 70);
$list->insertLast(88, 88);


$list->delete(88);

//20 - 50 - 70 - 88


//$list->insertAfter(50, 1000, 1000);
//var_dump( $list->deleteLast() );

var_dump( $list );