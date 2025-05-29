<?php

namespace SortedLinkedList\Model\AVLTree;

use SortedLinkedList\Model\SortedListNodeInterface;

class AVLTreeNode implements SortedListNodeInterface {

    /**
     * @var AVLTreeNode|null
     */
    public ?AVLTreeNode $left = null;

    /**
     * @var AVLTreeNode|null
     */
    public ?AVLTreeNode $right = null;

    /**
     * @var AVLTreeNode|null
     */
    public ?AVLTreeNode $parent = null;

    /**
     * @var int
     */
    public int $height = 1;

    /**
     * @param mixed $value
     */
    public function __construct(public mixed $value)
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
        // check right node
        if ($this->right !== null) {
            $current = $this->right;
            while($current->left != null) {
                $current = $current->left;
            }
            return $current;
        }

        // if no right nodes, go higher until we find a left child
        $current = $this;
        while($current->parent !== null && $current->parent->right === $current) {
            $current = $current->parent;
        }

        return $current->parent;
    }

    /**
     * @inheritDoc
     */
    public function setNext(?SortedListNodeInterface $next): void
    {
        throw new \RuntimeException("We cannot set value to the AVL tree node");
    }

}