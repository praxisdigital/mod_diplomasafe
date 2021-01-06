<?php
/**
 * @developer   Johnny Drud
 * @date        04-01-2021
 * @company     https://diplomasafe.com
 * @copyright   2021 Diplomasafe ApS
 */

namespace mod_diplomasafe\collections;

use mod_diplomasafe\collection;
use mod_diplomasafe\factories\template_factory;

defined('MOODLE_INTERNAL') || die();

/**
 * Class
 *
 * @package mod_diplomasafe\collections
 */
class templates extends collection
{
    /**
     * Constructor
     *
     * @throws \dml_exception
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
        $templates_factory = new template_factory();
        return $templates_factory->get_repository()
            ->get_all_records();
    }
}
