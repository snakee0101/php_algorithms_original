<?php

class BinaryTree
{
    public function __construct(public ?Node $root)
    {

    }

    //ищем узкл в дереве по значению ключа.
    public function find($key): ?Node
    {
        $current = $this->root;

        while ($current->key != $key && $current != null) {
            $current = $key < $current->key ? $current->left_child
                : $current->right_child;
        }

        return $current;
    }

    /*public function find($key, ?Node $current_node): ?Node   //рекурсивная версия - обычно поиск начинаем с корня - поэтому в $current_node нужно передать корневой узел
    {
        if($current_node == null || $current_node->key == $key) //если нашли узел с нужным ключом или достигли самого вложенного узла и узел не найден
            return $current_node; //- возвращаем найденный узел или null

        //погружаемся в дерево в зависимости от значения ключа - ищем узел в левой (меньшей) или правой (большей) половине дерева - уменьшаем размер проблемы/охват поиска до одного узла
        return $key < $current_node->key ? $this->find($key, $current_node->left_child) //возвращаем результат по цепочке вызовов
                                         : $this->find($key, $current_node->right_child);
    }*/

    public function insert($inserted_key, $data): Node
    {
        if( $this->find( $inserted_key ) )
            throw new Exception('Item with this key already exists');

        $current = $this->root; //начнем с корня дерева

        while (true) {
            $child = $inserted_key < $current->key ? 'left_child' : 'right_child'; //в зависимости от того, меньше или больше искомый ключ от текущго - будет обрабатывать левый или правый дочерний элемент соответственно

            if ($current->$child == null)
                return $current->$child = new Node($inserted_key, $data);

            $current = $current->$child;
        }
    }

    /*public function recInsert(Node $inserted_node, $current_node): Node
    {
       if( $current_node == null )   //если текущий узел не задан - достигли конца дерева - дальше опускаться некуда (БАЗА ИНДУКЦИИ)
           return $inserted_node;  //- вернем новый узел (потому что его нужно вставить в ПРЕДЫДУЩИЙ УЗЕЛ - а при возврате как раз в предыдущий узел и попадаем)

        //найдем правильную позицию, куда вставить элемент (согласно величине ключа) - опускаемся до самого вложенного элемента
       if( $inserted_node->key < $current_node->key ) //если ключ вставляемого узла меньше текущего - его нужно вставить слева
           $current_node->left_child = $this->recInsert($inserted_node, $current_node->left_child); //переходим к левому дочернему элементу
       //после возврата самого вложенного узла из ф-ии (а это именно вставляемый узел - $inserted_node) мы будем находиться на предыдущем узле ($current_node)
       //- вставляемый узел должен стать соответствующим дочерним элементом предыдущего узла (потому что до вставки предыдущий узел был последним - а вставляют узлы всегда в конец - т.е. в качестве дочернего элемента последнего элемента дерева)
         else //если ключ вставляемого узла больше текущего - его нужно вставить справа
           $current_node->right_child = $this->recInsert($inserted_node, $current_node->right_child); //переходим к правому дочернему элементу

        return $current_node;   //возвращаем корневой узел - чтобы получить доступ к верхушке дерева и выйти из рекурсии
    }*/

    public function traverse($node)
    {
        if ($node == null)
            return;

        var_dump($node->data);

        $this->traverse($node->left_child);
        $this->traverse($node->right_child);
    }

    public function min(): ?Node
    {
        $current = $this->root;

        while ($current->left_child != null)
            $current = $current->left_child;

        return $current;
    }

    public function max(): ?Node
    {
        $current = $this->root;

        while ($current->right_child != null)
            $current = $current->right_child;

        return $current;
    }

    public function findParent($key)
    {
        $current = $this->root; //начнем с корня дерева

        while (true) {
            $child = $key < $current->key ? 'left_child' : 'right_child'; //в зависимости от того, меньше или больше искомый ключ от текущго - будет обрабатывать левый или правый дочерний элемент соответственно

            if ($current->left_child->key == $key || $current->right_child->key == $key)    //если ключ одного из дочерних элементов совпадает - значит, это родительский элемент отноистельно требуемого
                return $current;

            $current = $current->$child;
        }
    }

    public function getSuccessor($key)
    {
        $node = $this->find($key);

        $current = $node->right_child; //сначала переходим к правому дочернему элементу (потому что узел-наследник больше чем текущий...)

        while ($current->left_child != null) //пока мы не дошли до самого вложенного левого элемента (... но наименьший из них)
            $current = $current->left_child;    //переходим вниз по дереву

        return $current;
    }

    public function delete($key)
    {
        if ($this->root->key == $key) {  //если удаляемый узел - корень дерева - обнуляем его
            $this->root = null;
            return;
        }

        $node = $this->find($key);
        $parent = $this->findParent($key);

        if ($node->left_child == null && $node->right_child == null)     //если удаляемый узел не имеет дочерних элементов
        {
            //отключаем удаляемый узел от родительского
            ($parent->left_child->key == $key) ? $parent->left_child = null
                : $parent->right_child = null;
        }

        if ($node->left_child != null xor $node->right_child != null)     //если удаляемый узел имеет ОДИН дочерний элемент
        {
            $child_node = $node->left_child ?: $node->right_child;  //найдем дочерний элемент относительно удаляемого

            ($parent->left_child->key == $key) ? $parent->left_child = $child_node //если удаляемый элемент присоединен к левой стороне - то к ней и присоединяем дочерний элемент
                : $parent->right_child = $child_node; //а если к правой стороне - то присоединяем к правой
        }

        if ($node->left_child != null && $node->right_child != null)     //если удаляемый узел имеет ДВА дочерних элемента
        {
            $successor = $this->getSuccessor($key);

            if ($successor->key == $node->right_child->key) //если узел-наследник – это правый дочерний узел относительно удаляемого.
            {
                $parent->right_child = $successor;
                $successor->left_child = $node->left_child;
            }

            if ($successor->key == $node->right_child->left_child->key) //узел-наследник – это левый дочерний узел правого дочернего узла относительно удаляемого.
            {
                if($successor->key != $node->right_child->key)
                {
                    $successor_parent = $this->findParent($successor->key);

                    $successor_parent->left_child = $successor->right_child;
                    $successor->right_child = $node->right_child;
                }

                $parent = $this->findParent($node->key);

                $parent->right_child = $successor;
                $successor->left_child = $node->left_child;
            }
        }
    }
}

class Node
{
    public function __construct(public int $key,
                                public     $data,
                                public     $left_child = null,
                                public     $right_child = null)
    {

    }
}

function print_leaves($root_node)   //
{
    if($root_node == null)  //чтобы не выводились узлы, которых не существует
        return;

    if( $root_node->left_child == null && $root_node->right_child == null ) {    //если нашли узел-лист
        echo "leaf node key = [$root_node->key]\n"; //выводим его

        return; //и выходим из рекурсии
    }

    //т.е. для каждого данного узла $root_node мы обрабатываем и его левое, и его правое поддерево (одновременно - потому что обращения содержатся в одном вызове - так можно покрыть все дерево)
    print_leaves( $root_node->left_child ); //обрабатываем левое поддерево (опускаемся к самому вложенному элементу)
    print_leaves( $root_node->right_child ); //обрабатываем правое поддерево  (опускаемся к самому вложенному элементу)
}


$n_82 = new Node(82, 82);
$n_92 = new Node(92, 92, $n_82);

$n_70 = new Node(70, 70);
$n_80 = new Node(80, 80, $n_70, $n_92);

$tree = new BinaryTree($n_80);

//print_leaves( $tree->root );
var_dump( $tree->find(80, $tree->root) );



/*$n_57 = new Node(57, 57);
$n_60 = new Node(60, 60);

$n_58 = new Node(58, 58, $n_57, $n_60);
$n_33 = new Node(33, 33);

$n_51 = new Node(51, 51, $n_33, $n_58);

$n_26 = new Node(26, 26);
$n_13 = new Node(13, 13, null, $n_26);

$n_27 = new Node(27, 27, $n_13, $n_51);

$n_82 = new Node(82, 82);
$n_92 = new Node(92, 92, $n_82);

$n_70 = new Node(70, 70);
$n_80 = new Node(80, 80, $n_70, $n_92);

$n_63 = new Node(63, 63, $n_27, $n_80);

$tree = new BinaryTree($n_63);*/

/*$n_93 = new Node(93, 93);
$n_62 = new Node(62, 62);
$n_79 = new Node(79, 79);

$n_77 = new Node(77, 77, right_child: $n_79);


$n_87 = new Node(87, 87, $n_77, $n_93);
$n_75 = new Node(75, 75, $n_62, $n_87);
$n_50 = new Node(50, 50, right_child: $n_75);


$tree = new BinaryTree($n_50);*/

//$tree->delete(13);
//$tree->delete(57);

//var_dump($tree);

/**
 * $B = $mul = new Node(4, 'B');
 * $C = $mul = new Node(5, 'C');
 *
 *
 * $plus = new Node(3, '+', $B, $C);
 *
 * $A = $mul = new Node(2, 'A');
 *
 * $mul = new Node(1, '*', $A, $plus);
 * $tree = new BinaryTree($mul);
 *
 * $tree->traverse( $tree->root );*/

/**
 *            60
 *        40
 *    30     50
 */

//var_dump( $node );
//var_dump( $tree );
//var_dump( $tree->find(51) );