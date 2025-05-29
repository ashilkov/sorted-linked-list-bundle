<?php
declare(strict_types = 1);

namespace SortedLinkedList\Tests\Model;

use SortedLinkedList\Model\SortedArrayList\SortedArrayList;
use SortedLinkedList\Model\SortedLinkedListInterface;

class SortedArrayListTest extends AbstractSortedLinkedListTest
{
    protected function createSortedLinkedList(): SortedLinkedListInterface
    {
        return new SortedArrayList();
    }
}