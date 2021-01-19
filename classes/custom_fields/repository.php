<?php
/**
 * @developer   Johnny Drud
 * @date        19-01-2021
 * @company     https://diplomasafe.com
 * @copyright   2021 Diplomasafe ApS
 */

namespace mod_diplomasafe\custom_fields;

use core_course\customfield\course_handler;

defined('MOODLE_INTERNAL') || die();

/**
 * Class
 *
 * @package mod_diplomasafe
 */
class repository
{
    /**
     * @var int
     */
    private $course_id;

    /**
     * Constructor
     *
     * @param int $course_id
     */
    public function __construct(int $course_id) {
        $this->course_id = $course_id;
    }

    /**
     * @param string $field_code
     *
     * @return mixed|string
     */
    public function get_field_data(string $field_code)
    {
        $handler = course_handler::create();

        $datas = $handler->get_instance_data($this->course_id);

        $metadata = [];
        foreach ($datas as $data) {
            if (empty($data->get_value())) {
                continue;
            }
            $metadata[$data->get_field()->get('shortname')] = $data->get_value();
        }

        return $metadata[$field_code] ?? '';
    }
}
