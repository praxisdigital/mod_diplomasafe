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
     *
     * @param array|null $available_language_ids
     *
     * @throws \coding_exception
     * @throws \dml_exception
     */
    public function __construct(array $available_language_ids = null) {
        $languages = $this->get_data($available_language_ids);
        $this->set($languages);
    }

    /**
     * @param array|null $available_language_ids
     *
     * @return mixed
     * @throws \coding_exception
     * @throws \dml_exception
     */
    private function get_data(array $available_language_ids = null) {
        return language_factory::get_repository()
            ->get_all_records($available_language_ids);
    }
}
