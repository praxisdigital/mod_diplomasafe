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
 * @package mod_diplomasafe
 *
 * @property $course_id
 * @property $user_id
 * @property $completion_fetched
 * @property $completed
 * @property $error_message
 */
class user_completion_course extends entity
{
    /**
     * @return mixed|void
     */
    public function set_data() {
        $this->data = [
            'course_id' => null,
            'user_id' => null,
            'completion_fetched' => false,
            'completed' => false,
            'error_message' => ''
        ];
    }

    /**
     * Constructor
     *
     * @param $params
     */
    public function __construct($params) {
        $required_params = ['user_id', 'course_id', 'completion_fetched', 'completed'];
        $this->process_params($params, $required_params);
    }

    /**
     * @return bool
     */
    public function is_completed() : bool {
        return $this->data['completion_fetched'] && $this->data['completed'];
    }
}
