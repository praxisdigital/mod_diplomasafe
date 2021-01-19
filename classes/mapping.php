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
    /**
     * @const string
     */
    public const MOODLE_COURSE_DATE = 'moodle_course_date';

    /**
     * @const string
     */
    public const MOODLE_COURSE_PERIOD = 'moodle_course_period';

    /**
     * @const string
     */
    public const MOODLE_DURATION = 'moodle_duration';

    /**
     * @const string
     */
    public const MOODLE_INSTRUCTOR = 'moodle_instructor';

    /**
     * @const string
     */
    public const MOODLE_LOCATION = 'moodle_location';

    /**
     * @const array
     */
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
        ]
    ];

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

    /**
     * @return string
     * @throws \dml_exception
     * @throws client\exceptions\base_url_not_set
     * @throws client\exceptions\current_environment_invalid
     * @throws client\exceptions\current_environment_not_set
     * @throws client\exceptions\personal_access_token_not_set
     */
    public function get_remote_id(): string {
        $reflect = new \ReflectionClass($this);
        $mapping_class = $reflect->getShortName();

        $config = factory::get_api_config();
        if ($config->is_test_environment()) {
            return self::MAPPING_FIELDS[$mapping_class]['test_idnumber'] ?? '';
        }
        return self::MAPPING_FIELDS[$mapping_class]['prod_idnumber'] ?? '';
    }
}
