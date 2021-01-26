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
     * @var array
     */
    private $ids_by_key = [];

    /**
     * Constructor
     *
     * @param bool $only_available
     *
     * @throws \coding_exception
     * @throws \dml_exception
     */
    public function __construct(bool $only_available = false) {
        $languages = $this->get_data($only_available);
        foreach ($languages as $language) {
            $this->ids_by_key[$language->name] = $language->id;
        }
        $this->set($languages);
    }

    /**
     * @param string $key
     *
     * @return bool
     */
    public function key_exists(string $key) : bool {
        return isset($this->ids_by_key[$key]);
    }

    /**
     * @param bool $only_available
     *
     * @return mixed
     * @throws \coding_exception
     * @throws \dml_exception
     */
    private function get_data(bool $only_available = false) {
        return language_factory::get_repository()
            ->get_all_records($only_available);
    }
}
