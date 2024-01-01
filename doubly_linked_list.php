<?php

class DoublyLinkedListItem
{
    public ?self $next, //ссылка на следующий элемент
        $prev; //ссылка на предыдущий элемент

    public function __construct(
        public $key,
        public $data
    ) {
    }
}

class DoublyLinkedList
{
    public ?DoublyLinkedListItem $first = null,   //первый элемент списка
        $last = null;    //последний элемент списка

    public function find($key)  //the same technique, as in normal linked list
    {
        $item = $this->first;

        while ($item) {
            if ($item->key === $key)
                return $item;

            $item = $item->next;
        }
    }

    public function isEmpty(): bool
    {
        return $this->first === null;
    }

    public function insertFirst($data, $key = null): DoublyLinkedListItem
    {
        if ($this->find($key))
            throw new Exception('Item with such key already exists');

        $item = new DoublyLinkedListItem($data, $key ?? rand());  //key is required

        $item->next = $this->first; //insert item before the first item
        $item->prev = null;

        if ($this->isEmpty())
            $this->last = $item;    //set last item if the list is empty
        else
            $this->first->prev = $item; //otherwise - old first item must point (->prev) to the inserted item

        return $this->first = $item;   //dont forget about $list->first pointer
    }

    public function insertAfter($after_key, $data, $key = null): DoublyLinkedListItem
    {
        if ($this->find($key))
            throw new Exception('Item with such key already exists');

        $inserted = new DoublyLinkedListItem($data, $key ?? rand());  //key is required

        $after = $this->find($after_key);

        $inserted->next = $after->next;
        $inserted->prev = $after;

        if ($after->next != null)    //if the item is not the last item
            $inserted->next->prev = $inserted;  //set the ->prev pointer of the next item to the inserted item

        return $after->next = $inserted;
    }

    public function insertLast($data, $key = null): DoublyLinkedListItem
    {
        $item = $this->isEmpty() ? $this->insertFirst($data, $key) //if the list is empty - process the inserted item separately
            : $this->insertAfter($this->last->key, $data, $key);  //otherwise - insert after the last item

        return $this->last = $item;    //dont forget to change the pointer to the last item
    }

    public function deleteFirst(): DoublyLinkedListItem
    {
        $deleted = $this->first;

        $this->first = $this->first->next;
        $this->first->prev = null;

        return $deleted;
    }

    public function deleteLast(): DoublyLinkedListItem
    {
        $deleted = $this->last;

        $this->last = $this->last->prev;
        $this->last->next = null;

        return $deleted;
    }

    public function delete($key): DoublyLinkedListItem
    {
        $deleted = clone $this->find($key); //clone solves the references problem

        if ($deleted == $this->first)       //process the deletion of the first and last item separately
            return $this->deleteFirst();
        elseif ($deleted == $this->last)
            return $this->deleteLast();

        $deleted->prev->next = $deleted->next;  //previous item must point to next one
        $deleted->next->prev = $deleted->prev;  //and the next item must point to previous

        return $deleted;
    }
}


$list = new DoublyLinkedList();


$_50 = $list->insertFirst(50, 50);
$_20 = $list->insertFirst(20, 20);
$_10 = $list->insertFirst(10, 10);

$list->insertLast(70, 70);
$list->insertLast(88, 88);
$list->insertLast(90, 90);


$list->delete(70);
$list->deleteLast();
print_r($list->deleteFirst());

//20 - 50 - 70 - 88


$list->insertAfter(50, 1000, 1000);
//var_dump( $list->deleteLast() );

print_r($list);
