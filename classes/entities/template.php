<?php
/**
 * @developer   Johnny Drud
 * @date        04-01-2021
 * @company     https://diplomasafe.com
 * @copyright   2021 Diplomasafe ApS
 */

namespace mod_diplomasafe\entities;

use mod_diplomasafe\entity;

defined('MOODLE_INTERNAL') || die();

/**
 * Class
 *
 * @package mod_diplomasafe\entities
 *
 * @property $organisation_id
 * @property $default_language_id
 * @property $idnumber
 * @property $name
 * @property $is_valid
 */
class template extends entity
{
    /**
     * @return mixed|void
     */
    public function set_data() {
        $this->data = [
            'organisation_id' => '',
            'default_language_id' => null,
            'idnumber' => '',
            'name' => '',
            'is_valid' => false
        ];
    }

    /**
     * Constructor
     *
     * @param $params
     */
    public function __construct($params) {
        $required_params = ['organisation_id', 'default_language_id', 'idnumber', 'name', 'is_valid'];
        $this->process_params($params, $required_params);
    }
}
