<?php
/**
 * @developer   Johnny Drud
 * @date        04-01-2021
 * @company     https://diplomasafe.com
 * @copyright   2021 Diplomasafe ApS
 */

namespace mod_diplomasafe;

use mod_diplomasafe\traits\array_access;
use mod_diplomasafe\traits\countable;
use mod_diplomasafe\traits\iterator;

defined('MOODLE_INTERNAL') || die();

class collection implements \ArrayAccess, \Iterator, \Countable
{
    /** Traits for ArrayAccess, Iterator and Countable */
    use array_access, iterator, countable;

    /** @var array */
    protected $data = [];

    /**
     * @param $data
     * @param bool $wrap
     * @throws \RuntimeException
     */
    public function set($data, $wrap = false): void{
        // If we need to wrap it in a specific class defined in the collection
        if($wrap === true){
            $data = $this->wrap($data);
        }

        $this->data = $data;
    }

    /**
     * @return \moodle_database
     */
    protected static function db(): \moodle_database{
        global $DB;
        return $DB;
    }

    /**
     * @param array $entities
     * @return array
     * @throws \RuntimeException
     */
    protected function wrap(array $entities): array{

        $data = array_values($entities);
        foreach($data as $key => $item){
            $data[$key] = new $this->model((array)$item);
        }

        return $data;
    }

    /**
     * @param string $field
     * @param string $direction
     * @return collection
     */
    public function sort($field = 'id', $direction = 'asc'): collection{
        if (strtolower($direction) === 'desc') {
            $this->sort_desc($field);
            return $this;
        }
        $this->sort_asc($field);
        return $this;
    }

    /**
     * @param string $field
     * @return collection
     */
    public function sort_asc($field = 'id'): collection{
        usort($this->data, static function($a, $b) use ($field){
            return strnatcmp($a->{$field}, $b->{$field});
        });
        return $this;
    }

    /**
     * @param string $field
     * @return collection
     */
    public function sort_desc($field = 'id'): collection{
        usort($this->data, static function($a, $b) use ($field){
            return strnatcmp($b->{$field}, $a->{$field});
        });
        return $this;
    }

    /**
     * @return int
     */
    public function count(): int{
        return count($this->data);
    }

    /**
     * @return array
     */
    public function to_array(): array{
        return $this->data;
    }

    /**
     * @param int $from
     * @param int $to
     *
     * @return array
     */
    public function limit(int $from, int $to): array {
        return array_values(array_slice($this->data, $from, $to));
    }
}
