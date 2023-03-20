<?php

include "linked_list.php";

class Vertex    //пока без дополнительных данных
{
    public bool $wasVisited = false;

    public function __construct(public string $label)
    {
    }
}

class DirectedGraph
{
    public $vertexes, $adj;
    public $adj_transitive_closure; //дополнительно храним матрицу-транзитивное замыкание

    public function addVertex(string $label): void  //создает и сохраняет новую вершину в графе
    {
        if (@$this->vertexes[$label])
            throw new Exception('Vertex with this label already exists');

        $this->vertexes[$label] = new Vertex($label);
    }

    public function addEdge(string $start_vertex_label, string $end_vertex_label): void
    {
        $this->adj[$start_vertex_label][$end_vertex_label] = true;
    }

    public function noSuccessor()    //получаем любую вершину без наследников
    {
        foreach ($this->vertexes as $vertex)    //обойти все вершины
        {
            if (@$this->adj[ $vertex->label ] == null)  //если вершина не имеет своего индекса в матрице смежности - тогда у неё нет вершин-наследников
                return $vertex; //поэтому возвращаем её
        } //если вершин без наследников нет - возвращаем null (это происходит автоматически, потому что если ф-ия ничего не возвращает - то она возвращает null)
    }

    public function topologicalSort(): LinkedList
    {
        $list = new LinkedList();   //создадим список, где будем хранить вершины
        $g = clone $this;   //скопируем граф - потому что из него будем удалять вершины

        while ($noSuccessor = $g->noSuccessor()) //пока в графе не закончились вершины - берем любую вершину без наследников (потому что если вершин нет - все равно вернется null)
        {
            $list->insertFirst($noSuccessor);  //добавляем её в начало списка

            unset( $g->vertexes[ $noSuccessor->label ] ); //и удаляем эту вершину из списка вершин графа

            foreach ($g->adj as $adj_label => $adj_vertices) //удаляем вершину из матрицы смежности - пройтись по всем вершинам
            {
                unset( $g->adj[ $adj_label ][ $noSuccessor->label ] );   //и отвязать от них удаляемую
            }
        }

        return $list;   //в конце вернем отсортированный список с вершинами
    }

    public function generate_transitive_closure()
    {
        $this->adj_transitive_closure = $this->adj;     //сначала копируем исходную матрицу смежности

        //теперь ищем пересечения (сами пересечения ищем в оригинальной матрице, но записываем в новую матрицу)
        foreach ($this->adj as $y => $y_val)    //#1 (переменная $y) - обходим строки
        {
            foreach (@$this->adj[ $y ] as $x => $x_val)   //#2 (переменная $x) - обходим СТОЛБЦЫ [что равноценно существованию вершины $y->$x], чтобы найти 1 в ячейке матрицы - если столбец существует - это автоматически означает наличие ребра ($y->$x) - нашли пересечение в матрице
            {
                foreach (@$this->adj[ $x ] as $z => $z_val)  //#3 (переменная $z - сюда попадает столбец) - обходим СТРОКУ $x [что равноценно существованию вершины $x->$z], чтобы попытаться найти ребро ($x->$z), которое является продолжением ребра ($y->$x) [т.е. другое ребро начинается на том индексе, где первое заканчивается]
                {
                    //если существуют вершины ($y->$x) И ($x->$z) - тогда существует и вершина ($y->$z), КОТОРУЮ мы запишем в матрицу [проверять наличие вершины не нужно - потому что по вершинам, которые не существуют, цикл пройтись не сможет]
                    if($y != $z)    //вершины не должны дублироваться
                        $this->adj_transitive_closure[ $y ][ $z ] = true;
                }
            }
        }
    }

    public function isConnected($label_start, $label_end) :bool
    {
        return $this->adj_transitive_closure[ $label_start ][ $label_end ] != null;
    }
}


$dg = new DirectedGraph();
$dg->addVertex('X');
$dg->addVertex('Y');
$dg->addVertex('Z');

$dg->addVertex('N');
$dg->addVertex('B');


$dg->addEdge('X', 'Y');
$dg->addEdge('Y', 'Z');
$dg->addEdge('N', 'B');

$dg->generate_transitive_closure();

var_dump( $dg->isConnected('N', 'B') );

/*$list = $dg->topologicalSort();
var_dump( $list->first->data->label );
var_dump( $list->first->next->data->label );
var_dump( $list->first->next->next->data->label );
var_dump( $list->first->next->next->next->data->label );*/

//var_dump($dg->topologicalSort());

//            A
//      N-E-B  F  C-D
//            G-H-I
//