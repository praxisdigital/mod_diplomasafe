<?php
/**
 * @developer   Johnny Drud
 * @date        14-01-2021
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
 * @property int $id
 * @property string $name
 */
class language extends entity
{
    /**
     * @return mixed|void
     */
    public function set_data() {
        $this->data = [
            'id' => null,
            'name' => ''
        ];
    }

    /**
     * Constructor
     *
     * @param $params
     */
    public function __construct($params) {
        $required_params = [
            'name'
        ];
        $this->process_params($params, $required_params);
    }

    /**
     * @param string $language_code
     *
     * @return void
     */
    public static function set_locale(string $language_code) : void {
        setlocale(LC_TIME, $language_code . '.UTF-8');
    }
}
