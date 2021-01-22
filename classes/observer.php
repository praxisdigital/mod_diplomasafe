<?php
/**
 * @developer   Johnny Drud
 * @date        13-01-2021
 * @company     https://diplomasafe.com
 * @copyright   2021 Diplomasafe ApS
 */

namespace mod_diplomasafe;

use core\event\course_completed;
use mod_diplomasafe\entities\queue_item;
use mod_diplomasafe\factories\template_factory;

defined('MOODLE_INTERNAL') || die();

/**
 * Class
 *
 * @package mod_diplomasafe
 */
class observer
{
    /**
     * @param course_completed $course_completed
     *
     * @throws \dml_exception
     * @throws \coding_exception
     */
    public static function course_completed(course_completed $course_completed) : void {
        if (!empty($course_completed->courseid)
            && !empty($course_completed->relateduserid)) {
            try {
                $template_repository = template_factory::get_repository();
                $template_repository->get_by_course_id($course_completed->courseid);
                $now = time();
                $queue = new queue();
                $queue->push(new queue_item([
                    'course_id' => $course_completed->courseid,
                    'user_id' => $course_completed->userid,
                    'status' => queue_item::QUEUE_ITEM_STATUS_PENDING,
                    'time_created' => $now,
                    'time_modified' => $now,
                ]));
            } catch (\RuntimeException $e) {}
        }
    }
}
