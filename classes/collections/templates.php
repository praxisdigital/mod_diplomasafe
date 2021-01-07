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
     * @param int|null $language_id
     *
     * @throws \dml_exception
     */
    public function __construct(int $language_id = null) {
        $data = $this->get_data($language_id);
        $this->set($data);
    }

    /**
     * @param int|null $language_id
     *
     * @return mixed
     * @throws \dml_exception
     */
    private function get_data(int $language_id = null) {
        return template_factory::get_repository()
            ->get_all_records($language_id);
    }
}
