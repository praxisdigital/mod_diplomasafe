<?php
namespace mod_diplomasafe\task;

use coding_exception;
use core\task\scheduled_task;
use lang_string;

/**
 * @developer   Johnny Drud
 * @date        04-01-2021
 * @company     https://diplomasafe.com
 * @copyright   2021 Diplomasafe ApS
 */
defined('MOODLE_INTERNAL') || die();

/**
 * Class
 *
 * @package mod_diplomasafe\task
 */
class store_diploma_templates extends scheduled_task
{
    /**
     * @return lang_string|string
     * @throws coding_exception
     */
    public function get_name() {
        return get_string('cron_store_diploma_templates', 'mod_diplomasafe');
    }

    public function execute() {
        // Todo: Implement method
    }
}
