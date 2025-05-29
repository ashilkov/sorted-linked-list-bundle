<?php
declare(strict_types = 1);

namespace SortedLinkedList\Model\LinkedList;

use SortedLinkedList\Model\AbstractSortedLinkedList;
use SortedLinkedList\Model\SortedLinkedListInterface;

class LinkedList extends AbstractSortedLinkedList implements SortedLinkedListInterface
{
    /**
     * @var LinkedListNode|null
     */
    private ?LinkedListNode $head = null;

    /**
     * @inheritDoc
     */
    public function insert(mixed $value): void
    {
        $this->validateValue($value);

        $node = new LinkedListNode($value);

        // empty list or new value is smaller than current head
        if ($this->head === null || $this->head->getValue() >= $value) {
            $node->setNext($this->head);
            $this->head = $node;

            return;
        }

        // iterate through list to find position for new element
        $current = $this->head;
        while ($current->getNext() !== null && $current->getNext()->getValue() < $value) {
            $current = $current->getNext();
        }
        $node->setNext($current->getNext());
        $current->setNext($node);
    }

    /**
     * @inheritDoc
     */
    public function remove(mixed $value): bool
    {
        // empty list
        if ($this->head === null) {
            return false;
        }

        // remove head
        if ($this->head->getValue() === $value) {
            $this->head = $this->head->getNext();

            return true;
        }
        
        // iterate through the list
        $current = $this->head;
        while ($current->getNext() !== null && $current->getNext()->getValue() != $value) {
            $current = $current->getNext();
        }

        if ($current->getNext() !== null) {
            $current->setNext($current->getNext()->getNext());

            return true;
        }

        return false;
    }

    /**
     * @inheritDoc
     */
    public function toArray(): array
    {
        $result = [];
        $current = $this->head;
        while($current !== null) {
            $result[] = $current->getValue();
            $current = $current->getNext();
        }

        return $result;
    }

    /**
     * @inheritDoc
     */
    public function isEmpty(): bool
    {
        return $this->head === null;
    }
}