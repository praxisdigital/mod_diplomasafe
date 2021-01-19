<?php
/**
 * @developer   Johnny Drud
 * @date        18-01-2021
 * @company     https://diplomasafe.com
 * @copyright   2021 Diplomasafe ApS
 */

namespace mod_diplomasafe\mappings;

use mod_diplomasafe\contracts\mapping_interface;
use mod_diplomasafe\factory;
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
    public const REMOTE_ID_TEST = 305;
    public const REMOTE_ID_PROD = 231;

    /**
     * @return string
     */
    public function get_data(): string {
        return (int)$this->course->startdate !== 0 ? userdate($this->course->startdate) : '';
    }

    /**
     * @return string
     * @throws \dml_exception
     * @throws \mod_diplomasafe\client\exceptions\base_url_not_set
     * @throws \mod_diplomasafe\client\exceptions\current_environment_invalid
     * @throws \mod_diplomasafe\client\exceptions\current_environment_not_set
     * @throws \mod_diplomasafe\client\exceptions\personal_access_token_not_set
     */
    public function get_remote_id(): string {
        $config = factory::get_api_config();
        if (!$config->is_test_environment()) {
            return self::REMOTE_ID_TEST;
        }
        return self::REMOTE_ID_PROD;
    }
}
