<?php

class LinkedListItem
{
    public $next;

    public function __construct(
        public $data,
        public $key
    ) {
    }
}

class LinkedList
{
    public $first;

    /**
     * If the key is not explicitly set (key == null) - create a random key,
     * because it's required as an identifier of a list item
     */
    protected function createListItem($data, $key = null): LinkedListItem
    {
        if ($this->find($key))
            throw new Exception('Item with such key already exists');

        return new LinkedListItem($data, $key ?? rand());
    }

    public function isEmpty(): bool
    {
        return $this->first === null;
    }

    public function insertFirst($data, $key = null): LinkedListItem
    {
        $item = $this->createListItem($data, $key);

        $item->next = $this->first;     //inserted item must point to the item that was first before
        return $this->first = $item;    //first list item ($list->first) must point to the inserted item.
    }

    public function findPrevious($key): LinkedListItem
    {
        $current = $this->first;

        while ($current) {
            if ($current->next->key === $key)  //if the next item is the item we are searching for - then it is the previous item
                return $current;

            $current = $current->next;
        }
    }

    public function delete($key)
    {
        //call the specific method to delete the first item
        if ($this->first->key === $key)
            $this->deleteFirst();

        $prev = $this->findPrevious($key);

        $deleted_item = $prev->next;        //find the item that will be deleted
        $prev->next = $deleted_item->next;  //just skip the deleted item

        return $deleted_item;
    }

    public function insertAfter($after_key, $data, $key = null)
    {
        $item = $this->createListItem($data, $key);
        $after = $this->find($after_key); //the item, after which $item is inserted

        $item->next = $after->next; //inserted $item must point to the item next to it
        return $after->next = $item;   //previous item ($after) must point to the inserted $item
    }

    public function insertLast($data, $key = null): LinkedListItem
    {
        if ($this->first == null)   #if there is not first item - create and return it
            return $this->insertFirst($data, $key);

        $item = $this->createListItem($data, $key);

        $last_item = $this->first;

        while ($last_item?->next != null)    //find the last item
            $last_item = $last_item->next;

        return $last_item->next = $item;    //insert created item after the last one
    }

    public function deleteFirst(): LinkedListItem
    {
        $item = $this->first;

        $this->first = $this->first->next; //head of the list must point to the second item (item, next to the first)

        return $item;
    }

    public function find($key): ?LinkedListItem
    {
        $item = $this->first;   //the search starts from the first item

        while ($item) //go through all items, while next item exists
        {
            if ($item->key === $key)    //if the item is found (by $key)
                return $item;   //then return it

            $item = $item->next; //go to the next item
        }

        return null;    //if item doesn't exist - return null
    }
}
