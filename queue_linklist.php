<?php

include 'linked_list.php';

class Queue
{
    private $items; //связанный список - счетчики не требуются

    public function __construct()
    {
        $this->items = new LinkedList();    //создаем пустой связанный список для хранения элементов
    }

    public function insert($data)
    {
        return $this->items->insertLast( $data );
    }

    public function remove()
    {
        if( $this->isEmpty() )
            throw new Exception('Nothing to delete. The queue is empty');

        return $this->items->deleteFirst();
    }

    public function peek()
    {
        return $this->items->first;
    }

    public function isEmpty() :bool
    {
        return $this->items->isEmpty();
    }
}

$q = new Queue();

$q->insert( 10 );  //1
$q->insert( 20 );  //1
$q->insert( 30 );  //1
//$q->insert( 'rtyry' );  //2
//$q->insert( [5, 7, 'y'] ); //3

$q->remove( );

var_dump( $q );