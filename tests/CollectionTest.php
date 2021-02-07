<?php
declare(strict_types=1);

namespace Tests;

use Domino\Collection;
use PHPUnit\Framework\TestCase;

class CollectionTest extends TestCase
{
    public function testCollectionIsEmptyByDefault()
    {
        $collection = new Collection();
        $this->assertEmpty($collection->toArray());
        $this->assertEquals(0, $collection->count());
    }

    public function testCanCreateCollectionFromArray()
    {
        $data       = ['foo', 'bar', 'baz'];
        $collection = new Collection($data);
        $this->assertEquals($data, $collection->toArray());
    }

    public function testCollectionIsIterable()
    {
        $data       = ['foo', 'bar', 'baz'];
        $collection = new Collection($data);

        $counter = 0;
        foreach ($collection as $item) {
            $this->assertSame($data[$counter], $item);
            $counter++;
        }

        $this->assertEquals(3, $counter, "The counter should be same as the number of element in the array");
    }

    public function testCanAddItems()
    {
        $collection = new Collection(['foo', 'bar']);

        $collection->add('baz');
        $this->assertEquals(['foo', 'bar', 'baz'], $collection->toArray());
    }

    public function testCanPrependItem()
    {
        $collection = new Collection(['foo', 'bar']);

        $collection->prepend('baz');
        $this->assertEquals(['baz', 'foo', 'bar'], $collection->toArray());
    }

    public function testCanAddItemByKey()
    {
        $collection = new Collection(['foo', 'bar']);

        $collection->set(0, 'baz');
        $this->assertEquals(['baz', 'bar'], $collection->toArray());

        $collection->set('qux', 'quux');
        $this->assertEquals(['baz', 'bar', 'qux' => 'quux'], $collection->toArray());
    }

    public function testCanGetRandomElement()
    {
        $data   = new Collection([1, 2, 3, 4, 5, 6]);
        $random = $data->random();
        $this->assertIsInt($random);
        $this->assertContains($random, $data->toArray());
    }

    public function testCanGetShiftOneItem()
    {
        $collection = new Collection(['foo', 'bar', 'baz']);

        $lastItem = $collection->shift();

        $this->assertEquals('foo', $lastItem);
        $this->assertEquals(['bar', 'baz'], $collection->toArray());
    }

    public function testCanGetShiftMultipleItems()
    {
        $collection = new Collection([1, 2, 3, 4, 5, 6]);

        $shiftedItems = $collection->shiftMany(3);

        $this->assertEquals([1, 2, 3], $shiftedItems->toArray());
        $this->assertEquals([4, 5, 6], $collection->toArray());


        $collection   = new Collection([1, 2]);
        $shiftedItems = $collection->shiftMany(5);

        $this->assertEquals([1, 2], $shiftedItems->toArray());
        $this->assertEquals([], $collection->toArray());

    }

    public function testCanGetFirstItem()
    {
        $collection = new Collection(['foo', 'bar', 'baz']);

        $this->assertEquals('foo', $collection->first());
    }

    public function testCanGetLastItem()
    {
        $collection = new Collection(['foo', 'bar', 'baz']);

        $this->assertEquals('baz', $collection->last());
    }

    public function testCanMergeCollections()
    {
        $collection = new Collection(['foo', 'bar', 'baz']);
        $toMerge    = new Collection(['bob', 'jon']);

        $collection->merge($toMerge);

        $this->assertEquals(['foo', 'bar', 'baz', 'bob', 'jon'], $collection->toArray());
    }

    public function testCanRemoveItem()
    {
        $collection = new Collection(['foo', 'bar', 'baz']);

        $collection->remove('bar');

        $this->assertEquals(['foo', 'baz'], array_values($collection->toArray()));
    }

}
