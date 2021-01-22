<?php
/**
 * @developer   Johnny Drud
 * @date        22-01-2021
 * @company     https://diplomasafe.com
 * @copyright   2021 Diplomasafe ApS
 */

defined('MOODLE_INTERNAL') || die();

require_once($CFG->dirroot.'/mod/diplomasafe/backup/moodle2/backup_diplomasafe_stepslib.php');
require_once($CFG->dirroot.'/mod/diplomasafe/backup/moodle2/backup_diplomasafe_settingslib.php');

/**
 * The class provides all the settings and steps to perform one complete backup of mod_diplomasafe.
 */
class backup_diplomasafe_activity_task extends backup_activity_task {

    /**
     * Defines particular settings for the plugin.
     */
    protected function define_my_settings() {
	    // No particular settings for this activity
    }

    /**
     * Defines particular steps for the backup process.
     */
    protected function define_my_steps() {
        $this->add_step(new backup_diplomasafe_activity_structure_step('diplomasafe_structure', 'diplomasafe.xml'));
    }

    /**
     * Codes the transformations to perform in the activity in order to get transportable (encoded) links.
     *
     * @param string $content.
     * @return string.
     */
    static public function encode_content_links($content) {
        return $content;
    }
}
