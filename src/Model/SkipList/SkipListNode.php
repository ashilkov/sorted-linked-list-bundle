<?php

namespace SortedLinkedList\Model\SkipList;

use SortedLinkedList\Model\SortedListNodeInterface;

class SkipListNode implements SkipListNodeInterface
{
    /**
     * @var array
     */
    protected array $forward = [];

    /**
     * @param mixed $value
     * @param int $level
     */
    public function __construct(protected mixed $value, protected int $level) 
    {
    }

    /**
     * @inheritDoc
     */
    public function getValue(): mixed {
        return $this->value;
    }

    /**
     * @inheritDoc
     */
    public function getNext(): ?SortedListNodeInterface
    {
        return $this->forward[0] ?? null;
    }

    /**
     * @inheritDoc
     */
    public function setNext(SortedListNodeInterface|null $next): void
    {
        $this->forward[0] = $next;
    }

    /**
     * @inheritDoc
     */
    public function getNextAtLevel(int $level): ?SkipListNodeInterface
    {
        return $this->forward[$level] ?? null;
    }

    /**
     * @inheritDoc
     */
    public function setNextAtLevel(?SkipListNodeInterface $next, int $level): void
    {
        $this->forward[$level] = $next;
    }
}