<?php
namespace mod_diplomasafe\task;

use coding_exception;
use core\task\scheduled_task;
use lang_string;
use mod_diplomasafe\cron_tasks;

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

    /**
     * @throws \dml_exception
     * @throws \mod_diplomasafe\client\exceptions\base_url_not_set
     * @throws \mod_diplomasafe\client\exceptions\current_environment_invalid
     * @throws \mod_diplomasafe\client\exceptions\current_environment_not_set
     * @throws \mod_diplomasafe\client\exceptions\invalid_argument_exception
     * @throws \mod_diplomasafe\client\exceptions\personal_access_token_not_set
     * @throws \moodle_exception
     */
    public function execute() {
        cron_tasks::create_templates();
    }
}
