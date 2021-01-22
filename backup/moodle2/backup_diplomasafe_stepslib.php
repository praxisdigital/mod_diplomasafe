<?php
/**
 * @developer   Johnny Drud
 * @date        22-01-2021
 * @company     https://diplomasafe.com
 * @copyright   2021 Diplomasafe ApS
 */

defined('MOODLE_INTERNAL') || die();

/**
 * Define the complete structure for backup, with file and id annotations.
 */
class backup_diplomasafe_activity_structure_step extends backup_activity_structure_step{

	/**
	 * Defines the structure of the resulting xml file
	 *
	 * @return backup_nested_element The structure wrapped by the common 'activity' element.
	 * @throws base_element_struct_exception
	 */
	protected function define_structure(){

		/**
		 * Creting XML elements
		 */
		$diplomasafe = new backup_nested_element('diplomasafe', ['id'], [
            'course', 'language_id', 'template_id', 'name', 'intro', 'introformat'
		]);

		/**
		 * Setting sources for for XML structure
		 */
		$diplomasafe->set_source_table('diplomasafe', [
			'id' => backup::VAR_ACTIVITYID
		]);

		$diplomasafe->annotate_files('mod_diplomasafe', 'content', null);

		return $this->prepare_activity_structure($diplomasafe);
	}
}
