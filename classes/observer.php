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
     * @throws \coding_exception
     * @throws \dml_exception
     * @throws \moodle_exception
     * @throws exceptions\base_url_not_set
     * @throws exceptions\current_environment_invalid
     * @throws exceptions\current_environment_not_set
     * @throws exceptions\personal_access_token_not_set
     */
    public static function course_completed(course_completed $course_completed) : void {
        if (!empty($course_completed->courseid)
            && !empty($course_completed->relateduserid)) {
            $template_repository = template_factory::get_repository();
            $mod_info = get_fast_modinfo($course_completed->courseid);
            $diplomasafe_modules = $mod_info->get_instances_of('diplomasafe');
            foreach ($diplomasafe_modules as $diplomasafe_module) {
                try {
                    if (empty($diplomasafe_module->instance)) {
                        throw new \RuntimeException('Instance not found');
                    }
                    $template = $template_repository->get_by_module_id($diplomasafe_module->instance);
                    if (!$template->exists()) {
                        throw new \RuntimeException('The template does not exist');
                    }
                    $now = time();
                    $queue = new queue(factory::get_config());
                    $queue->push(new queue_item([
                        'module_instance_id' => $diplomasafe_module->instance,
                        'user_id' => $course_completed->relateduserid,
                        'status' => queue_item::QUEUE_ITEM_STATUS_PENDING,
                        'time_created' => $now,
                        'time_modified' => $now,
                    ]));
                } catch (\RuntimeException $e) {
                    mtrace(get_string('message_could_not_push_to_queue', 'mod_diplomasafe', [
                        'course_id' => $course_completed->courseid,
                        'module_instance_id' => $diplomasafe_module->instance,
                        'user_id' => $course_completed->relateduserid,
                        'error' => $e->getMessage()
                    ]));
                }
            }
        }
    }
}
