<?php
/**
 * @developer   Johnny Drud
 * @date        18-01-2021
 * @company     https://diplomasafe.com
 * @copyright   2021 Diplomasafe ApS
 */

namespace mod_diplomasafe\factories;

use mod_diplomasafe\mapping;
use mod_diplomasafe\mappings\foak_person_id;
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
     * @param int $user_id
     * @return mapping_interface
     */
    public static function make(string $type, int $course_id, int $user_id) : mapping_interface {
        return match ($type) {
            mapping::MOODLE_COURSE_DATE => new moodle_course_date($course_id, $user_id),
            mapping::MOODLE_COURSE_PERIOD => new moodle_course_period($course_id, $user_id),
            mapping::MOODLE_DURATION => new moodle_duration($course_id, $user_id),
            mapping::MOODLE_INSTRUCTOR => new moodle_instructor($course_id, $user_id),
            mapping::MOODLE_LOCATION => new moodle_location($course_id, $user_id),
            mapping::FOAK_PERSON_ID => new foak_person_id($course_id, $user_id),
            default => throw new \RuntimeException('No or invalid mapping defined'),
        };
    }
}
