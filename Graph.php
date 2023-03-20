<?php

include 'queue.php';
include "stack.php";
include "linked_list.php";

class Vertex    //пока без дополнительных данных
{
    public bool $wasVisited = false;

    public function __construct(public string $label)
    {
    }
}

class Graph
{
    public $vertexes, //вершины графа    ->vertexes['vertex_label'] - хранит обьекты класса Vertex
        $adj;      //матрица смежности   ->adj['vertex_1_label']['vertex_2_label'] = true (связь есть) / null (связи нет)

    //матрица смежности   ->adj['vertex_2_label']['vertex_1_label'] = true (связь есть) / null (связи нет)

    public function addVertex(string $label): void  //создает и сохраняет новую вершину в графе
    {
        if (@$this->vertexes[$label])
            throw new Exception('Vertex with this label already exists');

        $this->vertexes[$label] = new Vertex($label);
    }

    public function addEdge(string $vertex_1_label, string $vertex_2_label): void   //создает ребро между двумя вершинами
    {
        $this->adj[$vertex_1_label][$vertex_2_label] =
        $this->adj[$vertex_2_label][$vertex_1_label] = true;
    }

    public function getAdjUnvisitedVertex($vertex_label): ?Vertex //возвращает первую соседнюю непосещенную вершину относительно данной или null, если такой нет
    {
        foreach ($this->adj[$vertex_label] as $adj_label => $is_connected)  //обходим соседние (берем их из матрицы смежности) относительно $vertex_label вершины и берем их метки $adj_label
        {
            if (!$this->vertexes[$adj_label]->wasVisited)    //если вершина не посещена
                return $this->vertexes[$adj_label];  //возвращаем её
        }

        return null;    //если соседних непосещенных вершин не найдено - возвращаем null
    }

    public function dfs($start_vertex_label)
    {
        $stack = new Stack();
        $stack->push($this->vertexes[$start_vertex_label]);    //добавим вершину, с которой начинается обход, в стек

        while ($stack->isEmpty() === false) //пока стек не опустел (т.е. пока не посетили все вершины)
        {
            $vertex_label = $stack->peek()->label;   //посмотрим на вершину на верхушке стека (текущая вершина)

            $v = $this->getAdjUnvisitedVertex($vertex_label); //возьмем первую непосещенную соседнюю вершину относительно данной ($vertex_label)

            if ($v) {  //если такая вершина существует
                echo $v->label . "\n"; //выполняем некоторое действие с вершиной - например, выведем её

                $v->wasVisited = true; //отмечаем вершину как посещенную
                $stack->push($v); //и делаем её текущей (добавляя вершину в стек)
            } else { //если соседних вершин нет
                $stack->pop(); //- удаляем текущую вершину из стека (т.е. теперь мы отходим на одну вершину назад)
            }
        }

        foreach ($this->vertexes as $vertex) //очистим метки о посещении со всех вершин
            $vertex->wasVisited = false;
    }

    public function mst($start_vertex_label): array
    {
        $stack = new Stack();
        $stack->push($this->vertexes[$start_vertex_label]);
        $path = [];     //массив для сохранения вершин (пути - путь состоит из последовательности вершин)

        while ($stack->isEmpty() === false) {
            $vertex_label = $stack->peek()->label;

            $v = $this->getAdjUnvisitedVertex($vertex_label);

            if ($v) {
                $path[] = $v->label;    //разница только в том, что мы записываем посещаемые вершины в массив - за счет этого формируя минимальный путь

                $v->wasVisited = true;
                $stack->push($v);
            } else {
                $stack->pop();
            }
        }

        foreach ($this->vertexes as $vertex)
            $vertex->wasVisited = false;

        return $path;   //возвращаем запомненный путь
    }

    public function bfs($start_vertex_label)
    {
        $this->vertexes[$start_vertex_label]->wasVisited = true; //начинаем с вершины $start_vertex_label - отмечаем её
        echo $start_vertex_label . "\n";    //показываем вершину

        $q = new Queue();
        $q->insert($this->vertexes[$start_vertex_label]);   //добавляем вершину в очередь

        while (!$q->isEmpty()) //пока очередь не пустая
        {
            $v1 = $q->remove(); // удаляем вершину в начале очереди (ВЗЯТЬ ТЕКУЩУЮ ВЕРШИНУ)

            //и пойти В ШИРИНУ (по всем ЕЁ СОСЕДЯМ)
            while (($v2 = $this->getAdjUnvisitedVertex($v1->label)) != null)   // (посещаем все непосещенные соседние вершины) пока у этой вершины не закончились не посещенные соседи
            {
                $v2->wasVisited = true; //взять соседнюю вершину и отметить её

                echo $v2->label . "\n";    //затем показать её
                $q->insert($v2);    //и добавить в очередь (выбрать НОВУЮ ТЕКУЩУЮ ВЕРШИНУ)
            }
        }

        foreach ($this->vertexes as $vertex) //очистим метки о посещении со всех вершин
            $vertex->wasVisited = false;
    }
}



$g = new Graph();
$g->addVertex('A');
$g->addVertex('B');
$g->addVertex('C');
$g->addVertex('D');
$g->addVertex('E');

$g->addEdge('A', 'B');
$g->addEdge('A', 'C');
$g->addEdge('A', 'D');
$g->addEdge('A', 'E');


$g->addEdge('B', 'C');
$g->addEdge('B', 'D');
$g->addEdge('B', 'E');

$g->addEdge('C', 'D');
$g->addEdge('C', 'E');

$g->addEdge('D', 'E');

var_dump( $g->mst('A') );