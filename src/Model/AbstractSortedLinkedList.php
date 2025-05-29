<?php
declare(strict_types = 1);

namespace SortedLinkedList\Model;

use RuntimeException;

abstract class AbstractSortedLinkedList implements SortedLinkedListInterface
{
    protected ?string $type = null;

    /**
     * Validate value type
     * 
     * @param mixed $value
     * @throws RuntimeException
     * @return void
     */
    protected function validateValue(mixed $value): void
    {
        if (!$this->type) {
            $this->type = gettype($value);

            return;
        }

        if ($this->type != gettype($value)) {
            if ($this->type !== gettype($value)){
                throw new RuntimeException(
                    sprintf("Please use the following type for this linked list values: %s. Used type: %s",
                    $this->type,
                    gettype($value)
                ));
            }
        }
    }
}