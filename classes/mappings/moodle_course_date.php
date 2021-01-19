<?php
/**
 * @developer   Johnny Drud
 * @date        18-01-2021
 * @company     https://diplomasafe.com
 * @copyright   2021 Diplomasafe ApS
 */

namespace mod_diplomasafe\mappings;

use mod_diplomasafe\contracts\mapping_interface;
use mod_diplomasafe\mapping;

defined('MOODLE_INTERNAL') || die();

/**
 * Class
 *
 * Get the course start date:
 * [Course startdate]
 *
 * @package mappings
 */
class moodle_course_date extends mapping implements mapping_interface
{
    /**
     * @return string
     */
    public function get_value(): string {
        if ((int)$this->course->startdate === 0) {
            return '';
        }
        return str_replace(', 00:00', '', userdate($this->course->startdate));
    }
}
