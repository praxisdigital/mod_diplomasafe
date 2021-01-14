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
 * @property int $id
 * @property template $template
 * @property int $course_id
 * @property int $user_id
 * @property string $issue_date
 * @property string $language_code
 * @property array $fields
 *
 */
class diploma extends entity
{
    /**
     * @return mixed|void
     */
    public function set_data() {
        $this->data = [
            'id' => null,
            'template' => null,
            'course_id' => null,
            'user_id' => null,
            'issue_date' => null,
            'language_code' => null,
            'fields' => []
        ];
    }

    /**
     * Constructor
     *
     * @param $params
     */
    public function __construct($params) {
        $required_params = ['template', 'course_id', 'user_id'];
        $this->process_params($params, $required_params);
    }
}
