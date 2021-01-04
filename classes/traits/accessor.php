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
trait accessor
{
    /**
     * @param $name
     * @return mixed
     */
    public function __get($name) {
        return $this->{$name};
    }

    /**
     * @param $name
     * @param $value
     */
    public function __set($name, $value) {
        $this->{$name} = $value;
    }

    /**
     * @param $name
     * @return bool
     */
    public function __isset($name) {
        return isset($this->{$name});
    }
}
