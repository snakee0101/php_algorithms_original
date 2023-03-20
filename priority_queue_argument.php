<?php

//отличие этой структуры в том, что приоритет элемента указывается при его создании -
//т.е. элемент очереди завернут в обьект (анонимный класс), который содержит поле с данными и поле с приоритетом

class PriorityQueueArgument
{
    //все операции остаются такими же, за исключением получения/сохранения данных, потому что нужно извлечь поле данных из обьекта-контейнера

    private int $nItems = 0;
    private array $items;

    private function priority_matches($prev_item, $current_item) :bool  //изменение: сравниваем приоритеты напрямую
    {
        return $prev_item->priority < $current_item->priority;
    }

    private function swap(&$value_1, &$value_2)
    {
        [$value_1, $value_2] = [$value_2, $value_1];
    }

    public function insert($data, $priority)    //изменение: сохраняем данные вместе с приоритетом (упаковываем их в обьект)
    {
        $this->items[ $this->nItems++ ] = new class($data, $priority) { //добавляемые элементы упаковываются в анонимный класс
            public function __construct(public $data, public $priority) { }
        };

        for($i = $this->nItems - 1; $i > 0; $i--)
        {
            if( !$this->priority_matches( $this->items[$i - 1], $this->items[$i] ) )
                $this->swap( $this->items[$i - 1], $this->items[$i] );
        }
    }

    public function remove() :mixed
    {
        return $this->items[ --$this->nItems ];
    }

    public function peek() :mixed
    {
        return $this->items[ $this->nItems - 1 ];   //индекс последнего элемента на 1 меньше, чем их кол-во ($this->nItems - 1)
    }

    public function size() :int
    {
        return $this->nItems;
    }

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

$q = new PriorityQueueArgument();

$q->insert($p1, 150);
$q->insert($p2, 10);
$q->insert($p3, 15);
$q->insert($p4, 200);


$q->remove();

$q->insert('data text', 75);


var_dump( $q );

//var_dump( $q );
