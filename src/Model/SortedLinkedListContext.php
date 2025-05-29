<?php
declare(strict_types = 1);

namespace SortedLinkedList\Model;

class SortedLinkedListContext
{
    /**
     * @param SortedLinkedListInterface $strategy
     */
    public function __construct(private SortedLinkedListInterface $strategy)
    {
    }

    /**
     * Set current strategy
     * 
     * @param SortedLinkedListInterface $strategy
     * @return void
     */
    public function setStrategy(SortedLinkedListInterface $strategy): void
    {
        $this->strategy = $strategy;
    }

    /**
     * Insert value into list
     * 
     * @param mixed $value
     * @throws \RuntimeException
     * @return void
     */
    public function insert(mixed $value): void
     {
        $this->strategy->insert($value);
    }

    /**
     * Remove value
     * 
     * @param mixed $value
     * @return bool
     */
    public function remove(mixed $value): bool
    {
        return $this->strategy->remove($value);
    }

    /**
     * Convert list to array
     * 
     * @return array
     */
    public function toArray(): array
    {
        return $this->strategy->toArray();
    }

    /**
     * Check if list is empty
     * 
     * @return bool
     */
    public function isEmpty(): bool
    {
        return $this->strategy->isEmpty();
    }
}