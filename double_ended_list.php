<?php

class Item
{
    public ?self $next;

    public function __construct(public $data) { }
}

class DoubleEndedList
{
    public ?LinkedListItem $first = null,
                 $last = null;

    public function isEmpty() :bool
    {
        return $this->first == null;
    }

    public function insertFirst(LinkedListItem $item)
    {
        /*при вставке ссылки ($this->first) и ($this->last) могут не сущевствовать
         * - ссылка ($this->first) всегда задается явно - это вставляемый элемент.
         * Ссылка ($this->last) может не сущевствовать, если список до этого был пустой
         * - тогда она тоже должна указывать не первый элемент
         * **/
        if( $this->isEmpty() )
            $this->last = $item;

        $item->next = $this->first;
        $this->first = $item;
    }

    public function insertLast(LinkedListItem $item)
    {
        if( !$this->isEmpty() )
            $this->last->next = $item;
        else
            $this->first = $item;

        $item->next = null;
        $this->last = $item;
    }

    public function deleteFirst() :LinkedListItem
    {
        $item = $this->first;

        $this->first = $this->first->next;

        if($this->first->next == null && $this->last->next == null)
            $this->last = null;

        return $item;
    }
}

$item_1 = new LinkedListItem(10);
$item_2 = new LinkedListItem(20);
$item_3 = new LinkedListItem(30);


//$item_1->next = $item_2;
//$item_2->next = $item_3;

$list = new DoubleEndedList();
$list->insertLast( $item_1 );
$list->insertLast( $item_2 );
$list->insertLast( $item_3 );

var_dump( $list->deleteFirst() );
var_dump( $list->first);
//var_dump( $list->first->next->data );

//var_dump( $list->find(40) );