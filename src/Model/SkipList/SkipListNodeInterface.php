<?php

namespace SortedLinkedList\Model\SkipList;

use SortedLinkedList\Model\SortedListNodeInterface;

interface SkipListNodeInterface extends SortedListNodeInterface
{
    /**
     * Get next item on specific level
     * 
     * @param int $level
     * @return SkipListNodeInterface|null
     */
    public function getNextAtLevel(int $level): ?SkipListNodeInterface;

    /**
     * Set next item on specific level
     * 
     * @param SkipListNodeInterface|null $next
     * @param int $level
     * @return void
     */
    public function setNextAtLevel(?SkipListNodeInterface $next, int $level): void;
}