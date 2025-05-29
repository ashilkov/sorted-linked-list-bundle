<?php
declare(strict_types = 1);

namespace SortedLinkedList\Model\LinkedList;

use SortedLinkedList\Model\SortedListNodeInterface;

class LinkedListNode implements SortedListNodeInterface
{

    /**
     * @param mixed $value
     * @param LinkedListNode|null $next
     */
    public function __construct(private mixed $value, private ?LinkedListNode $next = null)
    {
    }

    /**
     * @inheritDoc
     */
    public function getValue(): mixed
    {
        return $this->value;
    }

    /**
     * @inheritDoc
     */
    public function getNext(): ?SortedListNodeInterface
    {
        return $this->next;
    }

    /**
     * @inheritDoc
     */
    public function setNext(?SortedListNodeInterface $next): void
    {
        $this->next = $next;
    }
}