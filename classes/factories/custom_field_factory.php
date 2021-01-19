<?php
/**
 * @developer   Johnny Drud
 * @date        19-01-2021
 * @company     https://diplomasafe.com
 * @copyright   2021 Diplomasafe ApS
 */

namespace mod_diplomasafe\factories;

use mod_diplomasafe\custom_fields\repository;

defined('MOODLE_INTERNAL') || die();

/**
 * Class
 *
 * @package mod_diplomasafe\factories
 */
class custom_field_factory
{
    /**
     * @param int $course_id
     *
     * @return repository
     */
    public static function get_customfield_repository(int $course_id) : repository {
        return new repository($course_id);
    }
}
