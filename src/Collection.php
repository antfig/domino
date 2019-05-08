<?php
declare(strict_types=1);

namespace Domino;

class Collection implements \Iterator, \Countable
{
    /**
     * The collection's encapsulated array
     *
     * @var array
     */
    protected $items;

    /**
     * @param array $items
     */
    public function __construct(array $items = [])
    {
        $this->items = $items;
    }

    // Iterator

    /**
     * @inheritdoc
     */
    public function current()
    {
        return current($this->items);
    }

    /**
     * @inheritdoc
     */
    public function key()
    {
        return key($this->items);
    }

    /**
     * @inheritdoc
     */
    public function next()
    {
        next($this->items);
    }

    /**
     * @inheritdoc
     */
    public function rewind()
    {
        reset($this->items);
    }

    /**
     * @inheritdoc
     */
    public function valid()
    {
        return $this->key() !== null;
    }

    /**
     * Count elements of an object
     * @link https://php.net/manual/en/countable.count.php
     * @return int The custom count as an integer.
     * </p>
     * <p>
     * The return value is cast to an integer.
     * @since 5.1.0
     */
    public function count()
    {
        return count($this->items);
    }

    // Custom methods

    public function toArray(): array
    {
        return $this->items;
    }

    /**
     * Appends an item to the end of the collection
     *
     * @param mixed $value
     *
     * @return Collection
     */
    public function add($value): Collection
    {
        $this->items[] = $value;

        return $this;
    }

    /**
     * Prepend one element to the beginning of the collection
     *
     * @param $value
     *
     * @return Collection
     */
    public function prepend($value): Collection
    {
        array_unshift($this->items, $value);
        return $this;
    }

    /**
     * Sets the given key and value in the collection
     *
     * @param mixed $key
     * @param mixed $value
     *
     * @return Collection
     */
    public function set($key, $value): Collection
    {
        $this->items[$key] = $value;

        return $this;
    }

    /**
     * Get Random item from the collection
     * @return mixed
     */
    public function random()
    {
        $randomKey = array_rand($this->items, 1);
        return $this->items[$randomKey];
    }

    /**
     * Run a filter over each of the items
     * Array keys are preserved
     *
     * @param callable $callback
     *
     * @return Collection
     */
    public function filter(callable $callback): self
    {
        return new static(array_filter($this->items, $callback, ARRAY_FILTER_USE_BOTH));
    }

    /**
     * Shift one element off the beginning of collection
     *
     * @return mixed
     */
    public function shift()
    {
        return array_shift($this->items);
    }

    /**
     * Shift multiple items off the beginning of collection
     *
     * @param int $numberOfItems
     *
     * @return Collection
     */
    public function shiftMany(int $numberOfItems): Collection
    {
        $items = [];

        for ($i = 0; $i < $numberOfItems; $i++) {

            $item = $this->shift();

            if ($item === null) {
                break;
            }

            $items[] = $item;
        }

        return new static($items);
    }

    /**
     * Get first item of collection
     * @return mixed|null null when empty collection
     */
    public function first()
    {
        foreach ($this->items as $value) {
            return $value;
        }

        return null;
    }

    /**
     * Get last item of collection
     * @return mixed|null
     */
    public function last()
    {
        $reversedArray = array_reverse($this->items);

        foreach ($reversedArray as $value) {
            return $value;
        }

        return null;
    }

    /**
     * Shuffle the current collection
     */
    public function shuffle(): bool
    {
        return shuffle($this->items);
    }

    /**
     * Merge to collections
     * @param Collection $drawTiles
     */
    public function merge(Collection $drawTiles)
    {
        $this->items = array_merge($this->items, $drawTiles->toArray());
    }

    /**
     * Remove some item on collection by its value (type check)
     *
     * @param mixed $value
     */
    public function remove($value): void
    {
        foreach ($this->items as $key => $collectionValue) {
            if ($value === $collectionValue) {
                unset($this->items[$key]);
            }
        }
    }
}
