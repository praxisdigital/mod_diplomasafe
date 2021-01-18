<?php
/**
 * @developer   Johnny Drud
 * @date        18-01-2021
 * @company     https://diplomasafe.com
 * @copyright   2021 Diplomasafe ApS
 */

namespace mod_diplomasafe\factories;

use mappings\moodle_course_date;
use mappings\moodle_course_period;
use mappings\moodle_duration;
use mappings\moodle_instructor;
use mappings\moodle_location;
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
     *
     * @return mapping_interface
     */
    public static function make(string $type) : mapping_interface {
        switch ($type) {
            case 'moodle_course_date':
                return new moodle_course_date();
            case 'moodle_course_period':
                return new moodle_course_period();
            case 'moodle_duration':
                return new moodle_duration();
            case 'moodle_instructor':
                return new moodle_instructor();
            case 'moodle_location':
                return new moodle_location();
            default:
                throw new \RuntimeException('No or invalid mapping defined');
        }
    }
}
