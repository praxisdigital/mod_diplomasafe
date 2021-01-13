<?php
/**
 * @developer   Johnny Drud
 * @date        13-01-2021
 * @company     https://diplomasafe.com
 * @copyright   2021 Diplomasafe ApS
 */

namespace mod_diplomasafe\collections;

use mod_diplomasafe\collection;
use mod_diplomasafe\entities\queue_item;

defined('MOODLE_INTERNAL') || die();

/**
 * Class
 *
 * @package mod_diplomasafe\collections
 */
class queue_items extends collection
{
    /**
     * Constructor
     *
     * @param $items
     */
    public function __construct($items) {
        $this->set($items);
    }

    /**
     * @return queue_item|bool
     */
    public function get_next() {
        return next($this->data);
    }

    /**
     * @return queue_item|bool
     */
    public function get_current() {
        return current($this->data);
    }
}
