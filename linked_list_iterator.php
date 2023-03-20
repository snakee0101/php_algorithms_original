<?php

include 'linked_list.php';

class LinklistIterator implements Iterator
{
    private $current,   // ссылка на текущий элемент
            $prev,      // ссылка на предыдущий элемент
            $list;      // ссылка на сам список

    public function __construct( LinkedList $list )  //добавляем список, по которому проходимся, в конструкторе
    {
        $this->list = $list;

        $this->current = $list->first;  //начнем обход с первого элемента
        $this->prev = null; //перед первым элементов других элементов нет
    }

    public function current(): mixed    //возвращаем текущий элемент (он хранится как поле класса-итератора)
    {
        return $this->current;
    }

    public function next(): void    //переходим к следующему элементу, не возвращая его
    {
        $this->prev = $this->current;   //кроме того, сохраняем предыдущий элемент
        $this->current = $this->current->next;
    }

    public function key(): mixed    //возвращает ключ текущего элемента (необходим для выполнения операций с элементами)
    {
        return $this->current->key;
    }

    public function valid(): bool   //текущая позиция верна, если текущий элемент существует
    {
        return $this->current != null;
    }

    public function rewind(): void  //начинаем обход с начала (устанавилваем текущую позицию на первый элемент)
    {
        $this->current = $this->list->first;
        $this->prev = null;     //сбрасываем указатель на предыдущую позицию
    }


    //служебные операции
    public function atEnd() :bool   //проверяем, находимся ли мы в конце списка по отсутствию следующего элемента
    {
        return $this->current->next == null;
    }

    public function deleteCurrent() :LinkedListItem //удаляем текущий элемент
    {
        $item = $this->prev == null ? $this->list->deleteFirst() //если находимся в начале списка - выполняем специальную процедуру удаления
                                    : $this->list->delete( $this->key() );

        $this->atEnd() ? $this->rewind()  //после удаления элемента итератор надо сбросить - чтобы он указывал на начало, если мы были в конце списка
                       : $this->next();   //или на следующий элемент, если мы не в конце

        return $item;
    }

    public function insertBefore($data, $key) :LinkedListItem   //создадим и вставим элемент перед текущим - сразу перейдем к этому элементу
    {
        $inserted = new LinkedListItem($data, $key);

        if( $this->prev == null ) { //если находимся на первом элементе
            $inserted->next = $this->list->first;
            $this->list->first = $inserted;
        } else {    //если в любой другой позиции
            $this->prev->next = $inserted;
            $inserted->next = $this->current;
        }

        $this->current = $inserted; //переходим к вставленому элементу (изменять указатель на предыдущий элемент здесь не нужно)

        return $inserted;
    }

    public function insertAfter($data, $key) :LinkedListItem    //создадим и вставим элемент после текущего - сразу перейдем к этому элементу
    {
        $item = $this->list->insertAfter($this->key(), $data, $key);
        $this->next();

        return $item;
    }
}

$list = new LinkedList();
$list->insertLast(3, 3);
$list->insertLast(10, 10);
$list->insertLast(20, 20);
$list->insertLast(30, 30);
$list->insertLast(40, 40);
$list->insertLast(50, 50);
$list->insertLast(60, 60);


$iter = new LinklistIterator( $list );

while( $iter->valid() )
{
     $iter->current()->key % 3 == 0 ? $iter->deleteCurrent()     //переход к следующему элементу происходит автоматически
                                    : $iter->next();
}

var_dump( $iter );

/*$iter->rewind();
while( $iter->valid() )
{
    var_dump( $iter->current()->data );

    $iter->next();
}*/

/*var_dump( $iter->key() );
$iter->next();
var_dump( $iter->key() );

$iter->next();
var_dump( $iter->key() );

$iter->next();
var_dump( $iter->key() );


$iter->rewind();
var_dump( $iter->key() );*/
