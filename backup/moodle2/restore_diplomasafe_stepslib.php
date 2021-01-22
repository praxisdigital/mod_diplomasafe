<?php
/**
 * @developer   Johnny Drud
 * @date        22-01-2021
 * @company     https://diplomasafe.com
 * @copyright   2021 Diplomasafe ApS
 */

use mod_diplomasafe\helpers;

defined('MOODLE_INTERNAL') || die();

/**
 * To be able to retrieve data faster via get_fast_modinfo we save the cmid instead of the id of the actual instance.
 * That also does, that we only have one field to backup, instead of two. The downside is that the backup / restore is
 * a little more complex.
 *
 * Defines the structure step to restore one mod_diplomasafe activity.
 */
class restore_diplomasafe_activity_structure_step extends restore_activity_structure_step{

	protected function define_structure() {

		$paths = array();
		$paths[] = new restore_path_element('diplomasafe', '/activity/diplomasafe');

		// Return the paths wrapped into standard activity structure
		return $this->prepare_activity_structure($paths);
	}

	/**
	 * @param $data
	 * @throws base_step_exception
	 * @throws dml_exception
	 */
	protected function process_diplomasafe($data) { global $DB;

		$data = (object)$data;
		$oldid = $data->id;

		$data->module = $this->task->get_moduleid();
		$data->course = $this->get_courseid();

		$now = time();
		$data->timecreated = $now;
		$data->timemodified = $now;

		// Insert the diplomasafe record
		$newitemid = $DB->insert_record('diplomasafe', $data);

		// Immediately after inserting "activity" record, call this
		$this->apply_activity_instance($newitemid);
	}

	protected function after_execute() {

		$this->add_related_files('mod_diplomasafe', 'content', null);
	}
}
