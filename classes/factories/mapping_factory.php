<?php
/**
 * @developer   Johnny Drud
 * @date        18-01-2021
 * @company     https://diplomasafe.com
 * @copyright   2021 Diplomasafe ApS
 */

namespace mod_diplomasafe\factories;

use mod_diplomasafe\mapping;
use mod_diplomasafe\mappings\moodle_course_date;
use mod_diplomasafe\mappings\moodle_course_period;
use mod_diplomasafe\mappings\moodle_duration;
use mod_diplomasafe\mappings\moodle_instructor;
use mod_diplomasafe\mappings\moodle_location;
use mod_diplomasafe\contracts\mapping_interface;

defined('MOODLE_INTERNAL') || die();

/**
 * Class
 *
 * @package mod_diplomasafe\factories
 */
class mapping_factory
{
    /**
     * @param string $type
     * @param int $course_id
     *
     * @return mapping_interface
     * @throws \dml_exception
     */
    public static function make(string $type, int $course_id) : mapping_interface {
        switch ($type) {
            case mapping::MOODLE_COURSE_DATE:
                return new moodle_course_date($course_id);
            case mapping::MOODLE_COURSE_PERIOD:
                return new moodle_course_period($course_id);
            case mapping::MOODLE_DURATION:
                return new moodle_duration($course_id);
            case mapping::MOODLE_INSTRUCTOR:
                return new moodle_instructor($course_id);
            case mapping::MOODLE_LOCATION:
                return new moodle_location($course_id);
            default:
                throw new \RuntimeException('No or invalid mapping defined');
        }
    }
}
