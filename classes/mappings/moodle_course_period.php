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
 * Get the course period:
 * [Course startdate] – [Course enddate]
 *
 * @package mappings
 */
class moodle_course_period extends mapping implements mapping_interface
{
    /**
     * @return string
     */
    public function get_value(): string {
        $start_date = (int)$this->course->startdate !== 0 ? userdate($this->course->startdate) : '';
        $end_date = (int)$this->course->enddate !== 0 ? userdate($this->course->enddate) : '';
        $period = '';
        if (!empty($start_date) || !empty($end_date)) {
            $period = $start_date . ' - ' . $end_date;
        }
        return str_replace(', 00:00', '', $period);
    }
}
