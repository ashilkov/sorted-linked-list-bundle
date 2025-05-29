<?php
declare(strict_types = 1);

namespace SortedLinkedList\Model;

interface SortedListNodeInterface
{
    /**
     * Get value
     * 
     * @return mixed
     */
    public function getValue(): mixed;

    /**
     * Get next
     * 
     * @return SortedListNodeInterface|null
     */
    public function getNext(): ?SortedListNodeInterface;

    /**
     * Set next
     * 
     * @param SortedListNodeInterface|null $next
     * @return void
     */
    public function setNext(?SortedListNodeInterface $next): void;
}