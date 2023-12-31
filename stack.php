<?php

class Stack
{
    protected array $items;
    protected int $top = -1;

    public function push($data)
    {
        $this->items[++$this->top] = $data;
    }

    public function pop(): mixed
    {
        if ($this->top == -1)
            return null;

        return $this->items[$this->top--];
    }

    public function top(): mixed
    {
        return $this->items[$this->top] ?? null;
    }

    public function isEmpty(): bool
    {
        return $this->top == -1;
    }

    public function size()
    {
        return count($this->items);
    }
}


#Special implementation to make stack contents comparable
class ComparableStack
{
    protected array $items = [];

    public function push($data)
    {
        array_push($this->items, $data);
    }

    public function pop(): mixed
    {
        if (empty($this->items))
            return null;

        return array_pop($this->items);
    }

    public function top(): mixed
    {
        $key = array_key_last($this->items);

        return empty($this->items) ? null : $this->items[$key];
    }

    public function isEmpty(): bool
    {
        return empty($this->items);
    }

    public function size()
    {
        return count($this->items);
    }
}
