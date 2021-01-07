<?php
/**
 * @developer   Johnny Drud
 * @date        07-01-2021
 * @company     https://diplomasafe.com
 * @copyright   2021 Diplomasafe ApS
 */

namespace mod_diplomasafe\collections;

use mod_diplomasafe\collection;
use mod_diplomasafe\factories\language_factory;

defined('MOODLE_INTERNAL') || die();

/**
 * Class
 *
 * @package mod_diplomasafe\collections
 */
class languages extends collection
{
    /**
     * Constructor
     */
    public function __construct() {
        $data = $this->get_data();
        $this->set($data);
    }

    /**
     * @return mixed
     * @throws \dml_exception
     */
    private function get_data() {
        return language_factory::get_repository()
            ->get_all_records();
    }
}
