<?php
declare(strict_types = 1);

namespace SortedLinkedList\Tests\Model;

use SortedLinkedList\Model\SkipList\SkipList;
use SortedLinkedList\Model\SortedLinkedListInterface;

class SkipListTest extends AbstractSortedLinkedListTest
{
    protected function createSortedLinkedList(): SortedLinkedListInterface
    {
        return new SkipList();
    }
}