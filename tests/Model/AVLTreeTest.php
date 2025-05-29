<?php
declare(strict_types = 1);

namespace SortedLinkedList\Tests\Model;

use SortedLinkedList\Model\AVLTree\AVLTree;
use SortedLinkedList\Model\SortedLinkedListInterface;

class AVLTreeTest extends AbstractSortedLinkedListTest
{
    protected function createSortedLinkedList(): SortedLinkedListInterface
    {
        return new AVLTree();
    }
}