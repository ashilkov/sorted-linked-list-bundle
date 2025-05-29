<?php
declare(strict_types = 1);

namespace SortedLinkedList\Tests\Model;

use SortedLinkedList\Model\LinkedList\LinkedList;
use SortedLinkedList\Model\SortedLinkedListInterface;

class LinkedListTest extends AbstractSortedLinkedListTest
{
    protected function createSortedLinkedList(): SortedLinkedListInterface
    {
        return new LinkedList();
    }
}