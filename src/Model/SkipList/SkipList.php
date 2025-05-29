<?php

namespace SortedLinkedList\Model\SkipList;

use SortedLinkedList\Model\AbstractSortedLinkedList;
use SortedLinkedList\Model\SortedLinkedListInterface;

class SkipList extends AbstractSortedLinkedList implements SortedLinkedListInterface{

    /**
     * @var SkipListNodeInterface
     */
    private SkipListNodeInterface $head;

    /**
     * @var int
     */
    private int $level = 0;

    /**
     * @param int $maxLevel
     * @param float $p
     */
    public function __construct(protected int $maxLevel = 8, protected float $p = 0.5) {
        $this->head = new SkipListNode(null, $this->maxLevel);
    }

    /**
     * @inheritDoc
     */
    public function insert(mixed $value): void
    {
        // set list type and validate value type
        $this->validateValue($value);

        // create an update array to track values on different layers
        $update = array_fill(0, $this->maxLevel + 1, null);
        $current = $this->head;

        // find the previous value
        for($i = $this->level; $i >= 0; $i--) {
            while ($current->getNextAtLevel($i) !== null && $current->getNextAtLevel($i)->getValue() < $value) {
                $current = $current->getNextAtLevel($i);
            }

            $update[$i] = $current;
        }

        // specify list of layers where the value will be added
        $nodeLevel = $this->getRandomLevel();
        
        // init new layers
        if ($this->level < $nodeLevel) {
            for ($i = $this->level; $i <= $nodeLevel; $i++) {
                $update[$i] = $this->head;
            }
            $this->level = $nodeLevel;
        }

        $node = new SkipListNode($value, $nodeLevel);
        for ($i = 0; $i <= $nodeLevel; $i++) {
            $node->setNextAtLevel($update[$i]->getNextAtLevel($i), $i);
            $update[$i]->setNextAtLevel($node, $i);
        }
    }

    /**
     * @inheritDoc
     */
    public function remove(mixed $value): bool
    {
        // create an update array to track values on different layers
        $update = array_fill(0, $this->maxLevel + 1, null);
        $current = $this->head;

        // find the previous value
        for($i = $this->level; $i >= 0; $i--) {
            while ($current->getNextAtLevel($i) !== null && $current->getNextAtLevel($i)->getValue() < $value) {
                $current = $current->getNextAtLevel($i);
            }

            $update[$i] = $current;
        }
        // switching to the node that should be removed
        $current = $current->getNextAtLevel(0);

        // remove links to the node
        if ($current !== null and $current->getValue() == $value) {
            for ($i = 0; $i <= $this->level; $i++) {
                if ($update[$i]->getNextAtLevel($i) !== $current) {
                    break;
                }
                $update[$i]->setNextAtLevel($current->getNextAtLevel($i), $i);
            }

            //fix levels if needed
            while ($this->level > 0 && $this->head->getNextAtLevel($this->level)) {
                $this->level--;
            }

            return true;
        }

        return false;
    }

    /**
     * @inheritDoc
     */
    public function isEmpty(): bool
    {
        return $this->head->getNext() === null;
    }

    /**
     * @inheritDoc
     */
    public function toArray(): array
    {
        $result = [];
        $current = $this->head->getNext();

        while ($current !== null) {
            $result[] = $current->getValue();
            $current = $current->getNext();
        }

        return $result;
    }

    /**
     * Get a random item level based on probability factor (p)
     * 
     * @return int
     */
    protected function getRandomLevel(): int 
    {
        $level = 0;
        while((mt_rand() / mt_getrandmax()) < $this->p && $level < $this->maxLevel) {
            $level++;
        }

        return $level;
    }
}