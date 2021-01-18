<?php
// This file is part of Moodle - https://moodle.org/
//
// Moodle is free software: you can redistribute it and/or modify
// it under the terms of the GNU General Public License as published by
// the Free Software Foundation, either version 3 of the License, or
// (at your option) any later version.
//
// Moodle is distributed in the hope that it will be useful,
// but WITHOUT ANY WARRANTY; without even the implied warranty of
// MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
// GNU General Public License for more details.
//
// You should have received a copy of the GNU General Public License
// along with Moodle.  If not, see <https://www.gnu.org/licenses/>.

/**
 * Library of interface functions and constants.
 *
 * @package     mod_diplomasafe
 * @copyright   2020 Diplomasafe <info@diplomasafe.com>
 * @license     https://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */

use mod_diplomasafe\factories\template_factory;
use mod_diplomasafe\output\diplomasafe;

defined('MOODLE_INTERNAL') || die();

/**
 * Return if the plugin supports $feature.
 *
 * @param string $feature Constant representing the feature.
 * @return true | null True if the feature is supported, null otherwise.
 */
function diplomasafe_supports($feature) {
    switch ($feature) {
        case FEATURE_BACKUP_MOODLE2:
        case FEATURE_SHOW_DESCRIPTION:
        case FEATURE_MOD_INTRO:
            return true;
        default:
            return null;
    }
}

/**
 * Saves a new instance of the mod_diplomasafe into the database.
 *
 * Given an object containing all the necessary data, (defined by the form
 * in mod_form.php) this function will create a new instance and return the id
 * number of the instance.
 *
 * @param object $moduleinstance An object from the form.
 * @param null $mform The form.
 *
 * @return int The id of the newly inserted record.
 * @throws dml_exception
 */
function diplomasafe_add_instance($moduleinstance, $mform = null) {
    global $DB;

    $moduleinstance->timecreated = time();

    $id = $DB->insert_record('diplomasafe', $moduleinstance);

    return $id;
}

/**
 * Updates an instance of the mod_diplomasafe in the database.
 *
 * Given an object containing all the necessary data (defined in mod_form.php),
 * this function will update an existing instance with new data.
 *
 * @param object $moduleinstance An object from the form in mod_form.php.
 * @param mod_diplomasafe_mod_form $mform The form.
 *
 * @return bool True if successful, false otherwise.
 * @throws dml_exception
 */
function diplomasafe_update_instance($moduleinstance, $mform = null) {
    global $DB;

    $moduleinstance->timemodified = time();
    $moduleinstance->id = $moduleinstance->instance;

    return $DB->update_record('diplomasafe', $moduleinstance);
}

/**
 * Removes an instance of the mod_diplomasafe from the database.
 *
 * @param int $id Id of the module instance.
 *
 * @return bool True if successful, false on failure.
 * @throws dml_exception
 */
function diplomasafe_delete_instance($id) {
    global $DB;

    $exists = $DB->get_record('diplomasafe', array('id' => $id));
    if (!$exists) {
        return false;
    }

    $DB->delete_records('diplomasafe', array('id' => $id));

    return true;
}

/**
 * Extends the global navigation tree by adding mod_diplomasafe nodes if there is a relevant content.
 *
 * This can be called by an AJAX request so do not rely on $PAGE as it might not be set up properly.
 *
 * @param navigation_node $diplomasafenode An object representing the navigation tree node.
 * @param stdClass $course.
 * @param stdClass $module.
 * @param cm_info $cm.
 */
function diplomasafe_extend_navigation($diplomasafenode, $course, $module, $cm) {
}

/**
 * Extends the settings navigation with the mod_diplomasafe settings.
 *
 * This function is called when the context for the page is a mod_diplomasafe module.
 * This is not called by AJAX so it is safe to rely on the $PAGE.
 *
 * @param settings_navigation $settingsnav {@see settings_navigation}
 * @param navigation_node $diplomasafenode {@see navigation_node}
 */
function diplomasafe_extend_settings_navigation($settingsnav, $diplomasafenode = null) {
}

/**
 * Overwrites the content in the course-module object
 *
 * @param cm_info $cm
 * @throws coding_exception
 * @throws dml_exception
 * @throws moodle_exception
 */
function diplomasafe_cm_info_view(cm_info $cm) {
    if ($cm->uservisible) {
        global $PAGE;
        $renderer = $PAGE->get_renderer('mod_diplomasafe');
        try {
            $template_repo = template_factory::get_repository();
            $template = $template_repo->get_by_module_id($cm->instance);
            if (!$template->is_valid()) {
                throw new RuntimeException(get_string('message_template_invalid', 'mod_diplomasafe', $template->name));
            }
        } catch (RuntimeException $e) {
            $context_course = context_course::instance($cm->course);
            if (!has_capability('mod/assignment:submit', $context_course)) {
                $cm->set_content($renderer->render(new diplomasafe($e->getMessage())));
            }
        }
    }
}
