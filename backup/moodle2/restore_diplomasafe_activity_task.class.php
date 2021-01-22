<?php
/**
 * @developer   Johnny Drud
 * @date        22-01-2021
 * @company     https://diplomasafe.com
 * @copyright   2021 Diplomasafe ApS
 */

defined('MOODLE_INTERNAL') || die();

require_once($CFG->dirroot . '/mod/diplomasafe/backup/moodle2/restore_diplomasafe_stepslib.php');

/**
 * Restore task for mod_diplomasafe.
 */
class restore_diplomasafe_activity_task extends restore_activity_task{

	/**
	 * Defines particular settings that this activity can have.
	 */
	protected function define_my_settings(){
		// No particular settings for this activity
	}

	/**
	 * Defines particular steps that this activity can have.
	 * @return void .
	 * @throws base_task_exception
	 * @throws restore_step_exception
	 */
	protected function define_my_steps(){
		$this->add_step(new restore_diplomasafe_activity_structure_step('diplomasafe_structure', 'diplomasafe.xml'));
	}

	/**
	 * Defines the contents in the activity that must be processed by the link decoder.
	 *
	 * @return array.
	 */
	static public function define_decode_contents(){
		return [];
	}

	/**
	 * Defines the decoding rules for links belonging to the activity to be executed by the link decoder.
	 *
	 * @return array.
	 */
	static public function define_decode_rules(){
		return [];
	}

	/**
	 * Defines the restore log rules that will be applied by the
	 * {@link restore_logs_processor} when restoring mod_diplomasafe logs. It
	 * must return one array of {@link restore_log_rule} objects.
	 *
	 * @return array.
	 */
	static public function define_restore_log_rules(){
		return [];
	}
}
