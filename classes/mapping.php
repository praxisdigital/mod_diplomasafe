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
    private static ?config $config = null;

    public static function config(): config {
        if (static::$config === null) {
            static::$config = factory::get_config();
        }
        return static::$config;
    }

    public const MOODLE_COURSE_DATE = 'moodle_course_date';
    public const MOODLE_COURSE_PERIOD = 'moodle_course_period';
    public const MOODLE_DURATION = 'moodle_duration';
    public const MOODLE_INSTRUCTOR = 'moodle_instructor';
    public const MOODLE_LOCATION = 'moodle_location';

    public const FOAK_PERSON_ID = 'foak_d_person_id';

    public const MAPPING_FIELDS = [
        self::MOODLE_COURSE_DATE => [
            'field_code' => self::MOODLE_COURSE_DATE,
            'test_idnumber' => 305,
            'prod_idnumber' => 231
        ],
        self::MOODLE_COURSE_PERIOD => [
            'field_code' => self::MOODLE_COURSE_PERIOD,
            'test_idnumber' => 306,
            'prod_idnumber' => 232
        ],
        self::MOODLE_DURATION => [
            'field_code' => self::MOODLE_DURATION,
            'test_idnumber' => 302,
            'prod_idnumber' => 233
        ],
        self::MOODLE_INSTRUCTOR => [
            'field_code' => self::MOODLE_INSTRUCTOR,
            'test_idnumber' => 304,
            'prod_idnumber' => 235
        ],
        self::MOODLE_LOCATION => [
            'field_code' => self::MOODLE_LOCATION,
            'test_idnumber' => 303,
            'prod_idnumber' => 234
        ],
        self::FOAK_PERSON_ID => [
            'field_code' => self::FOAK_PERSON_ID,
            'test_idnumber' => 964,
            'prod_idnumber' => 718
        ]
    ];

    protected object $course;
    protected object $user;

    public function __construct(int $course_id, int $user_id) {
        $this->course = get_course($course_id);
        $this->user = \core_user::get_user($user_id) ?: (object)[];
    }

    abstract protected function get_field_name(): string;

    protected function is_test_environment(): bool
    {
        return self::config()->is_test_environment();
    }

    protected function get_id_property(): string
    {
        return $this->is_test_environment() ? 'test_idnumber' : 'prod_idnumber';
    }

    public function get_remote_id(): string {
        $field_name = $this->get_field_name();
        $property = $this->get_id_property();
        return self::MAPPING_FIELDS[$field_name][$property] ?? '';
    }
}
