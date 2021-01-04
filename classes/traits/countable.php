<?php
/**
 * @developer   Johnny Drud
 * @date        04-01-2021
 * @company     https://diplomasafe.com
 * @copyright   2021 Diplomasafe ApS
 */

namespace mod_diplomasafe\traits;

defined('MOODLE_INTERNAL') || die;

/**
 * Trait
 *
 * @package mod_diplomasafe\traits
 */
trait countable{

    /**
     * @return int
     */
    public function count(): int{
        return count($this->data);
    }
}
