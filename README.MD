# Sorted Linked List Bundle for Symfony

### Overview
The Symfony Sorted Lists Bundle provides a collection of robust, ready-to-use implementations for managing sorted collections in your Symfony projects. With this bundle, you can take advantage of four different data structures, each optimized for specific use cases:

• AVL Tree – A self-balancing binary search tree offering fast lookup, insertion, and deletion operations.
• Skip List – A probabilistic data structure that maintains sorted elements with efficient search and update performance.
• Linked List – A classic implementation of a linked list with a sorted order guarantee.
• Array-Based List with Binary Search – A list backed by an array that leverages binary search for quick retrieval in a sorted setup.


### Installation
1. Add repository to project's composer.json file
```
"repositories": [
    {
        "type": "git",
        "url": "https://github.com/ashilkov/sorted-linked-list-bundle.git"
    }
]
```
2. Install with composer
`
composer require ashilkov/sorted-linked-list-bundle
`

### Configuration
You can specify the default implementation using the DI container parameter `sorted_linked_list.default`. For example, use this markdown to use AVLTree:


`file: config/packages/sorted_linked_list.yaml:`
```yaml
sorted_linked_list:
    default: SortedLinkedList\Model\AVLTree\AVLTree
```

### Usage
After installation, you can inject the sorted list services into your controllers or services. For example:


```php
use SortedLinkedList\Model\SortedLinkedListInterface;

class TestController extends AbstractController
{
    public function __construct(private SortedLinkedListInterface $list)
    {
    }

    public function index()
    {
        $this->list->insert(10);
        $this->list->insert(3);
        $this->list->insert(213);

        return new JsonResponse(['list' => $this->list->toArray()]);
    }
}
```