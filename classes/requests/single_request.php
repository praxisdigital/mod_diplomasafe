<?php
/**
 * @developer   Johnny Drud
 * @date        06-01-2021
 * @company     https://diplomasafe.com
 * @copyright   2021 Diplomasafe ApS
 */

namespace mod_diplomasafe\requests;

use mod_diplomasafe\contracts\request_interface;
use mod_diplomasafe\cron_tasks;
use mod_diplomasafe\output\single;
use mod_diplomasafe\request;

defined('MOODLE_INTERNAL') || die();

/**
 * Class
 *
 * @package mod_diplomasafe\requests
 */
class single_request extends request implements request_interface
{
    /**
     * @return \renderable
     * @throws \coding_exception
     * @throws \moodle_exception
     * @throws \require_login_exception
     */
    public function process(): \renderable {

        global $DB, $PAGE;

        // Course_module ID, or
        $module_id = optional_param('id', 0, PARAM_INT);

        // ... module instance id.
        $module_instance_id  = optional_param('d', 0, PARAM_INT);

        if ($module_id) {
            $cm             = get_coursemodule_from_id('diplomasafe', $module_id, 0, false, MUST_EXIST);
            $course         = $DB->get_record('course', array('id' => $cm->course), '*', MUST_EXIST);
            $module_instance = $DB->get_record('diplomasafe', array('id' => $cm->instance), '*', MUST_EXIST);
        } else if ($module_instance_id) {
            $module_instance = $DB->get_record('diplomasafe', array('id' => $module_instance_id), '*', MUST_EXIST);
            $course         = $DB->get_record('course', array('id' => $module_instance->course), '*', MUST_EXIST);
            $cm             = get_coursemodule_from_instance('diplomasafe', $module_instance->id, $course->id, false, MUST_EXIST);
        } else {
            print_error(get_string('missingidandcmid', 'mod_diplomasafe'));
        }

        require_login($course, true, $cm);

        $modulecontext = \context_module::instance($cm->id);

        // PTODO: Fix course_module_viewed event
        //$event = \mod_diplomasafe\event\course_module_viewed::create(array(
        //    'objectid' => $module_instance->id,
        //    'context' => $modulecontext
        //));
        //$event->add_record_snapshot('course', $course);
        //$event->add_record_snapshot('diplomasafe', $module_instance);
        //$event->trigger();

        $PAGE->set_url('/mod/diplomasafe/view.php', [
            'id' => $cm->id
        ]);
        $PAGE->set_title(format_string($module_instance->name));
        $PAGE->set_heading(format_string($course->fullname));
        $PAGE->set_context($modulecontext);

        return new single($this->get_page(), $module_id);
    }
}
