<?php
/**
 * @developer   Johnny Drud
 * @date        18-01-2021
 * @company     https://diplomasafe.com
 * @copyright   2021 Diplomasafe ApS
 */

namespace mod_diplomasafe;

defined('MOODLE_INTERNAL') || die();

/**
 * Class
 *
 * @package mod_diplomasafe
 */
abstract class mapping
{
    public const COURSE_DATE = 'moodle_course_date';
    public const COURSE_PERIOD = 'moodle_course_period';
    public const COURSE_DURATION = 'moodle_duration';
    public const COURSE_INSTRUCTOR = 'moodle_instructor';
    public const COURSE_LOCATION = 'moodle_location';

    /**
     * @var int
     */
    protected $course;

    /**
     * Constructor
     *
     * @param int $course_id
     *
     * @throws \dml_exception
     */
    public function __construct(int $course_id) {
        $this->course = get_course($course_id);
    }
}
