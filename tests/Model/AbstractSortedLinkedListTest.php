<?php
declare(strict_types = 1);

namespace SortedLinkedList\Tests\Model;

use PHPUnit\Framework\TestCase;
use SortedLinkedList\Model\SortedLinkedListInterface;

abstract class AbstractSortedLinkedListTest extends TestCase
{
    abstract protected function createSortedLinkedList(): SortedLinkedListInterface;
    public function testIsEmpty(): void
    {
        $list = $this->createSortedLinkedList();

        // init
        $this->assertTrue($list->isEmpty());

        // has value
        $list->insert(4);
        $this->assertFalse($list->isEmpty());

        // value removed
        $list->remove(4);
        $this->assertTrue($list->isEmpty());
    }

    public function testInsertAndToArray(): void
    {
        $list = $this->createSortedLinkedList();
        $values = [523, 17, 313, 24, 20];
        foreach ($values as $value) {
            $list->insert($value);
        }
        $expectedSorted = [17, 20, 24, 313, 523];
        $this->assertSame($expectedSorted, $list->toArray());

        $list->insert( 17);
        array_unshift($expectedSorted, 17);
        $this->assertSame($expectedSorted, $list->toArray());
    }

    public function testRemove(): void
    {
        $list = $this->createSortedLinkedList();
        $values = [523, 17, 313, 24, 20];
        foreach ($values as $value) {
            $list->insert($value);
        }
        // remove existing
        $result = $list->remove(313);
        $this->assertTrue($result);

        // remove non-existing
        $result = $list->remove(23);
        $this->assertFalse($result);

        // check values
        $expectedAfterRemove = [17, 20, 24, 523];
        $this->assertSame($expectedAfterRemove, $list->toArray());
    }

    public function testIncorrectValue(): void
    {
        $list = $this->createSortedLinkedList();
    
        $list->insert(1);
        $this->expectException(\RuntimeException::class);
        $list->insert("2");
    }
}