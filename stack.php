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

    public function peek(): mixed
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
