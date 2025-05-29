<?php
declare(strict_types = 1);
namespace SortedLinkedList\Model;

interface SortedLinkedListInterface
{
    /**
     * Insert value
     * 
     * @param mixed $value
     * @throws \RuntimeException
     * @return void
     */
    public function insert(mixed $value): void;

    /**
     * Remove value
     * 
     * @param mixed $value
     * @return bool
     */
    public function remove(mixed $value): bool;

    /**
     * Convert to array
     * 
     * @return array
     */
    public function toArray(): array;

    /**
     * Check if list is empty
     * 
     * @return bool
     */
    public function isEmpty(): bool;
}