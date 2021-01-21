<?php
/**
 * @developer   Johnny Drud
 * @date        21-01-2021
 * @company     https://diplomasafe.com
 * @copyright   2021 Diplomasafe ApS
 */

namespace mod_diplomasafe\event;

defined('MOODLE_INTERNAL') || die();

/**
 * Class course_module_viewed
 *
 * @package mod_diplomasafe\event
 */
class course_module_viewed extends \core\event\course_module_viewed
{
	/**
	 * Initialize the event
	 */
	protected function init() {
		$this->data['objecttable'] = 'diplomasafe';
		parent::init();
	}
}
