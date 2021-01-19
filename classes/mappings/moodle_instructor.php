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
 * Get a comma separated list of users with the role
 * mod/diplomasafe:diplomasafeinstructor in course
 * content.
 *
 * @package mappings
 */
class moodle_instructor extends mapping implements mapping_interface
{
    public const REMOTE_ID_TEST = 304;
    public const REMOTE_ID_PROD = 235;

    /**
     * @return string
     * @throws \coding_exception
     */
    public function get_data(): string {
        $context_course = \context_course::instance($this->course->id);
        $instructor_users = get_users_by_capability($context_course, 'mod/diplomasafe:diplomasafeinstructor');

        if (empty($instructor_users)) {
            return '';
        }

        $instructors = [];
        foreach ($instructor_users as $instructor_user) {
            $instructors[$instructor_user->id] = $instructor_user->firstname . ' ' . $instructor_user->lastname;
        }

        $instructors = array_values($instructors);
        sort($instructors);

        return implode(', ', $instructors);
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
