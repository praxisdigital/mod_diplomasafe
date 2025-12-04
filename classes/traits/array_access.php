<?php
/**
 * @developer   Johnny Drud
 * @date        04-01-2021
 * @company     https://diplomasafe.com
 * @copyright   2021 Diplomasafe ApS
 */

namespace mod_diplomasafe\traits;

defined('MOODLE_INTERNAL') || die();

/**
 * Trait
 *
 * @package mod_diplomasafe\traits
 */
trait array_access{

    /**
     * @param mixed $key
     * @param mixed $value
     */
    public function offsetSet(mixed $key, mixed $value): void{
        if (is_null($key)) {
            $this->data[] = $value;
        } else {
            $this->data[$key] = $value;
        }
    }

    /**
     * @param $key
     * @return bool
     */
    public function offsetExists($key): bool{
        return isset($this->data[$key]);
    }

    /**
     * @param $key
     */
    public function offsetUnset($key): void{
        unset($this->data[$key]);
    }

    /**
     * @param $key
     * @return mixed|null
     */
    public function offsetGet($key): mixed
    {
        return $this->data[$key] ?? null;
    }
}
