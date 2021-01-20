<?php
/**
 * @developer   Johnny Drud
 * @date        08-01-2021
 * @company     https://diplomasafe.com
 * @copyright   2021 Diplomasafe ApS
 */

namespace mod_diplomasafe;

use mod_diplomasafe\factories\template_factory;

defined('MOODLE_INTERNAL') || die();

/**
 * Class
 *
 * @package mod_diplomasafe
 */
class cron_tasks
{
    /**
     * @throws \coding_exception
     * @throws \dml_exception
     */
    public static function process_queue() : void {
        $queue = new queue();
        $output_exception = factory::get_config()
            ->is_test_environment();
        $queue->process_pending($output_exception);
    }

    /**
     * @throws \dml_exception
     * @throws \moodle_exception
     * @throws client\exceptions\base_url_not_set
     * @throws client\exceptions\current_environment_invalid
     * @throws client\exceptions\current_environment_not_set
     * @throws client\exceptions\personal_access_token_not_set
     */
    public static function create_templates() : void {
        $api_repo = template_factory::get_api_repository();
        $mapper = template_factory::get_mapper();

        $admin_task_mailer = new admin_task_mailer();

        $templates = $api_repo->get_all();

        foreach ($templates as $template) {
            try {
                $mapper->store($template);
            } catch (\Exception $e) {
                $admin_task_mailer->send_to_all($e->getMessage());
                throw new \RuntimeException($e->getMessage());
            }
        }
    }
}
