<?php
/**
 * @developer   Johnny Drud
 * @date        13-01-2021
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
 * @property $id
 * @property $course_fullname
 * @property $module_instance_id
 * @property $user_id
 * @property $status
 * @property $message
 * @property $time_created
 * @property $time_modified
 * @property $last_run
 * @property $last_mail_sent
 */
class queue_item extends entity
{
    public const QUEUE_ITEM_STATUS_PENDING = 0;
    public const QUEUE_ITEM_STATUS_RUNNING = 1;
    public const QUEUE_ITEM_STATUS_SUCCESSFUL = 2;
    public const QUEUE_ITEM_STATUS_FAILED = 3;

    /**
     * @return mixed|void
     */
    public function set_data() {
        $this->data = [
            'id' => null,
            'module_instance_id' => null,
            'user_id' => null,
            'status' => null,
            'message' => '',
            'time_created' => null,
            'time_modified' => null,
            'last_run' => null,
            'last_mail_sent' => null
        ];
    }

    /**
     * Constructor
     *
     * @param $params
     */
    public function __construct($params) {
        $required_params = [
            'module_instance_id', 'user_id', 'status', 'time_modified'
        ];
        $this->process_params($params, $required_params);
    }

    /**
     * @param int $status
     *
     * @return array
     * @throws \coding_exception
     */
    public static function status_to_array(int $status) : array {
        switch ($status) {
            case self::QUEUE_ITEM_STATUS_PENDING:
                return [
                    'type' => 'secondary',
                    'text' => get_string('status_pending', 'mod_diplomasafe')
                ];
            case self::QUEUE_ITEM_STATUS_RUNNING:
                return [
                    'type' => 'primary',
                    'text' => get_string('status_running', 'mod_diplomasafe')
                ];
            case self::QUEUE_ITEM_STATUS_SUCCESSFUL:
                return [
                    'type' => 'success',
                    'text' => get_string('status_successful', 'mod_diplomasafe')
                ];
            case self::QUEUE_ITEM_STATUS_FAILED:
                return [
                    'type' => 'danger',
                    'text' => get_string('status_failed', 'mod_diplomasafe')
                ];
        }
        return [
            'type' => 'danger',
            'text' => get_string('missing_or_invalid_status', 'mod_diplomasafe')
        ];
    }
}
