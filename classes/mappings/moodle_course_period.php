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
 * Get the course period:
 * [Course startdate] – [Course enddate]
 *
 * @package mappings
 */
class moodle_course_period extends mapping implements mapping_interface
{
    public const REMOTE_ID_TEST = 306;
    public const REMOTE_ID_PROD = 232;

    /**
     * @return string
     */
    public function get_data(): string {
        $start_date = (int)$this->course->startdate !== 0 ? userdate($this->course->startdate) : '';
        $end_date = (int)$this->course->enddate !== 0 ? userdate($this->course->enddate) : '';
        $period = '';
        if (!empty($start_date) || !empty($end_date)) {
            $period = $start_date . ' - ' . $end_date;
        }
        return str_replace(', 00:00', '', $period);
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
