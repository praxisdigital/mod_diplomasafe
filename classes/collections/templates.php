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
     * @param array|null $available_template_ids
     *
     * @throws \coding_exception
     * @throws \dml_exception
     */
    public function __construct(int $language_id = null, array $available_template_ids = null) {
        $data = $this->get_data($language_id, $available_template_ids);
        $this->set($data);
    }

    /**
     * @param int|null $language_id
     * @param array|null $available_template_ids
     *
     * @return mixed
     * @throws \coding_exception
     * @throws \dml_exception
     * @throws \mod_diplomasafe\exceptions\base_url_not_set
     * @throws \mod_diplomasafe\exceptions\current_environment_invalid
     * @throws \mod_diplomasafe\exceptions\current_environment_not_set
     * @throws \mod_diplomasafe\exceptions\personal_access_token_not_set
     */
    private function get_data(int $language_id = null, array $available_template_ids = null) {
        return template_factory::get_repository()
            ->get_all_records($language_id, $available_template_ids);
    }
}
