<?php

include "linked_list.php";

function reverse($head) :LinkedListItem
{
    if( $head->next == null ) //,,, пока не достигнем конца
        return $head;   // - тогда последний элемент будет новым первым элементом

    $new_head = reverse( $head->next );     //рекурсивно переходим к следующему элементу...

    //как только достигли конца - можно начать менять указатели на элементы (переворачивать список)
    //на данный момент $head - это текущий элемент, а $new_head - вершина нового списка - новый первый элемент

    /**
     * нужно, чтобы следующий элемент ($head->next)
     * указывал ($head->next->next)
     * на текущий ($head)
     */
    $head->next->next = $head;
    $head->next = null;     //текущий элемент ($head) не должен ни на что указывать ($head->next), потому что предыдущий элемент, на который он должен указывать, мы получить не можем

    return $new_head;   //функция должна вернуть указатель на новый первый элемент - пробрасываем его
}


$list = new LinkedList( );
$list->insertFirst(30, 30);
$list->insertFirst(20, 20);
$list->insertFirst(10, 10);

var_dump( reverse($list->first) );