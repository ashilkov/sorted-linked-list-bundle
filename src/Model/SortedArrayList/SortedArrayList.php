<?php
declare(strict_types = 1);

namespace SortedLinkedList\Model\SortedArrayList;

use SortedLinkedList\Model\AbstractSortedLinkedList;
use SortedLinkedList\Model\SortedLinkedListInterface;

class SortedArrayList extends AbstractSortedLinkedList implements SortedLinkedListInterface
{
    /**
     * List items
     * 
     * @var array
     */
    private array $items = [];

    /**
     * @inheritDoc
     */
    public function insert(mixed $value): void 
    {
        $this->validateValue($value);

        $index = $this->findIndex($value);
        array_splice($this->items, $index, 0, $value);
    }

    /**
     * Binary search
     * 
     * @param mixed $value
     * @return int
     */
    private function findIndex(mixed $value): int
    {
        $low = 0;
        $high = count($this->items);

        while ($low < $high) {
            $mid = intdiv($low + $high, 2);
            if ($this->items[$mid] < $value) {
                $low = $mid + 1;
            } else {
                $high = $mid;
            }
        }

        return $low;
    }

    /**
     * @inheritDoc
     */
    public function remove(mixed $value): bool
    {
        $index = $this->findIndex($value);
        if ($index < count($this->items) && $this->items[$index] == $value) {
            array_splice($this->items, $index, 1);
            return true;
        }

        return false;
    }

    /**
     * @inheritDoc
     */
    public function toArray(): array
    {
        return $this->items;
    }

    /**
     * @inheritDoc
     */
    public function isEmpty(): bool
    {
        return empty($this->items);
    }
}