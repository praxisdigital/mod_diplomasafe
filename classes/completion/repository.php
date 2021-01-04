<?php
/**
 * @developer   Johnny Drud
 * @date        04-01-2021
 * @company     https://diplomasafe.com
 * @copyright   2021 Diplomasafe ApS
 */

namespace mod_diplomasafe\completion;

use mod_diplomasafe\collections\user_completion_courses;

defined('MOODLE_INTERNAL') || die();

/**
 * Class
 *
 * @package mod_diplomasafe\completion
 */
class repository {
    /**
     * @return user_completion_courses
     */
    public function get_user_completion_status_courses() : user_completion_courses {
        return new user_completion_courses();
    }
}
