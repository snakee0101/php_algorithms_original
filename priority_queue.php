<?php

class PriorityQueue
{
    private int $nItems = 0; //счетчик кол-ва элементов
    private array $items; //хранит элементы, добавляемые в очередь

    /* служебные процедуры
    **/
    private function priority_matches($prev_item, $current_item) :bool //узнаем, в правильном ли порядке расположен элемент, сравнивая его приоритет с предыдущим элементом
    {  //приоритетом будем считать что-угодно, допустим, цену на товар (чем больше цена - тем выше приоритет)
        return $prev_item->price < $current_item->price; //элемент с большим приоритетом должен находиться в конце массива
    }

    private function swap(&$value_1, &$value_2) //обмен элементов местами
    {
        [$value_1, $value_2] = [$value_2, $value_1];
    }

    public function insert($item) //добавляем элемент в очередь в соответствии с его приоритетом
    {
        $this->items[ $this->nItems++ ] = $item; //добавляем элемент в последнюю позицию

        for($i = $this->nItems - 1; $i > 0; $i--) //обходим все элементы от конца к началу
        {
            if( !$this->priority_matches( $this->items[$i - 1], $this->items[$i] ) ) //если элементы расположены в неправильном порядке
                $this->swap( $this->items[$i - 1], $this->items[$i] ); //обменять их местами
        }
    }

    /* элементы удаляются ИЗ НАЧАЛА ОЧЕРЕДИ (с позиции с большим индексом),
     * - счетчик индексов ($nItems) сразу же уменьшается на 1
    **/
    public function remove() :mixed
    {
        return $this->items[ --$this->nItems ];
    }

    /* возвращаем элемент из начала очереди без его удаления
    **/
    public function peek() :mixed
    {
        return $this->items[ $this->nItems - 1 ];   //индекс последнего элемента на 1 меньше, чем их кол-во ($this->nItems - 1)
    }

    public function size() :int
    {
        return $this->nItems;
    }

    /* Пустая очередь - очередь, РАЗМЕР (кол-во элементов) которой равен НУЛЮ.
    **/
    public function isEmpty() :bool
    {
        return $this->size() === 0;
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

$q->insert($p1);
$q->insert($p2);
$q->insert($p3);
$q->insert($p4);

var_dump( $q );

//var_dump( $q );
