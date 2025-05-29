<?php
declare(strict_types = 1);

namespace SortedLinkedList\Model\AVLTree;

use SortedLinkedList\Model\AbstractSortedLinkedList;
use SortedLinkedList\Model\SortedLinkedListInterface;

class AVLTree extends AbstractSortedLinkedList implements SortedLinkedListInterface {

    /**
     * @var AVLTreeNode|null
     */
    private ?AVLTreeNode $root = null;

    /**
     * Get node height
     * 
     * @param AVLTreeNode|null $node
     * @return int
     */
    private function getHeight(?AVLTreeNode $node): int
    {
        return $node ? $node->height : 0;
    }

    /**
     * Get node balance
     * 
     * @param AVLTreeNode $node
     * @return int
     */
    private function getBalance(AVLTreeNode $node): int
    {
        if (!$node)
            return 0;

        return $this->getHeight($node->left) - $this->getHeight($node->right);
    }

    /**
     * Perform left rotation
     * 
     * @param AVLTreeNode $x
     * @return AVLTreeNode|null
     */
    private function rotateLeft(AVLTreeNode $x): AVLTreeNode {
        // validate if rotation is possible
        if ($x->right === null) {
            return $x;
        }

        $y = $x->right;
        $T2 = $y->left;

        $y->left = $x;
        $x->right = $T2;

        $y->parent = $x->parent;
        $x->parent = $y;

        if ($T2 !== null) {
            $T2->parent = $x;
        }

        $x->height = $this->calculateHeight($x);
        $y->height = $this->calculateHeight($y);

        return $y;
    }

    /**
     * Perform right rotation
     * 
     * @param AVLTreeNode $y
     * @return AVLTreeNode|null
     */
    private function rotateRight(AVLTreeNode $y): AVLTreeNode
    {
        // validate if rotation is possible
        if ($y->left === null) {
            return $y;
        }

        $x = $y->left;
        $T2= $x->right;

        $x->right = $y;
        $y->left = $T2;

        $x->parent = $y->parent;
        $y->parent = $x;

        if ($T2 !== null) {
            $T2->parent = $y;
        }

        $x->height = $this->calculateHeight($x);
        $y->height = $this->calculateHeight($y);

        return $x;
    }

    /**
     * @inheritDoc
     */
    public function insert(mixed $value): void
    {
        $this->root = $this->insertNode($this->root, $value, null);
    }

    /**
     * Insert node
     * 
     * @param AVLTreeNode|null $node
     * @param mixed $value
     * @param AVLTreeNode|null $parent
     * @return AVLTreeNode
     */
    private function insertNode(?AVLTreeNode $node, mixed $value, ?AVLTreeNode $parent): AVLTreeNode
    {
        $this->validateValue($value);

        if ($node === null) {
            $newNode  = new AVLTreeNode($value);
            $newNode->parent = $parent;

            return $newNode;
        }

        if ($value > $node->getValue()) {
            $node->right = $this->insertNode($node->right, $value, $node);
        } else {
            $node->left = $this->insertNode($node->left, $value, $node);
        }

        $node->height = $this->calculateHeight($node);
        $balance = $this->getBalance($node);

        // Left Left Case
        if ($balance > 1 && $value <= $node->left->getValue()) {
            return $this->rotateRight($node);
        }

        // Right Right Case
        if ($balance < -1 && $value > $node->right->getValue()) {
            return $this->rotateLeft($node);
        }
        
        // Left Right Case
        if ($balance > 1 && $value > $node->left->getValue()) {
            $node->left = $this->rotateLeft($node->left);
            return $this->rotateRight($node);
        }

        // Right Left Case
        if ($balance < -1 && $value < $node->right->getValue()){
            $node->right = $this->rotateRight($node->right);
            return $this->rotateLeft($node);
        }

        return $node;
    }

    private function calculateHeight(AVLTreeNode $node) : int
    {
        return max($this->getHeight($node->left), $this->getHeight($node->right)) + 1; 
    }

    /**
     * @inheritDoc
     */
    public function remove(mixed $value): bool
    {
        $removed = false;
        $this->root = $this->removeNode($this->root, $value, $removed);

        return $removed;
    }

    /**
     * Remove node
     * 
     * @param AVLTreeNode|null $node
     * @param mixed $value
     * @param bool $removed
     * @return AVLTreeNode|null
     */
    private function removeNode(?AVLTreeNode $node, mixed $value, bool &$removed): ?AVLTreeNode
    {
        if ($node === null) {
            return null;
        }

        if ($value < $node->getValue()) {
            $node->left = $this->removeNode($node->left, $value, $removed);
        } elseif ($value > $node->getValue()) {
            $node->right = $this->removeNode($node->right, $value, $removed);
        } else {
            // remove current node
            $removed = true;
            // node with one child on no childs
            if ($node->left === null || $node->right === null) {
                $temp = $node->left ?? $node->right;
                // no childs
                if ($temp === null) {
                    $node = null;
                } else {
                    //one child
                    $node = $temp;
                }
            } else {
                // replace current node with lowest right node and remove this node
                $temp = $this->getMinValueNode($node->right);
                $node->value = $temp->value;
                $node->right = $this->removeNode($node->right, $temp->value, removed: $removed);
            }
        }

        if ($node === null) {
            return null;
        }

        $node->height = $this->calculateHeight($node);
        $balance = $this->getBalance($node);

        // Left Left case
        if ($balance > 1 && $this->getBalance($node->left) >= 0) {
            return $this->rotateRight($node);
        } 

        // Right Right Case
        if ($balance < -1 && $this->getBalance($node->right) <= 0) {
            return $this->rotateLeft($node);
        }

        // Left Right Case
        if ($balance > 1 && $this->getBalance($node->left) < 0) {
            $node->left = $this->rotateLeft($node->left);
            return $this->rotateRight($node);
        }

        // Right Left Case
        if ($balance < -1 && $this->getBalance($node->right) > 0) {
            $node->right = $this->rotateRight($node->right);
            return $this->rotateLeft($node);
        }

        return $node;
    }

    /**
     * Find the lowest node
     * 
     * @param AVLTreeNode $node
     * 
     * @return AVLTreeNode
     */
    private function getMinValueNode(AVLTreeNode $node): AVLTreeNode {
        while($node->left != null) {
            $node = $node->left;
        }

        return $node;
    }

    /**
     * @inheritDoc
     */
    public function isEmpty(): bool
    {
        return $this->root === null;
    }

    /**
     * @inheritDoc
     */
    public function toArray(): array
    {
        $result = [];
        $this->DFS($this->root, $result);

        return $result;
    }

    /**
     * Depth First Search
     * 
     * @param AVLTreeNode|null $node
     * @param array $result
     * @return void
     */
    protected function DFS(?AVLTreeNode $node, array &$result): void {
        if ($node !== null) {
            $this->DFS($node->left, $result);
            $result[] = $node->getValue();
            $this->DFS($node->right, $result);
        }
    }
}