<?php
/**
 * @developer   Johnny Drud
 * @date        08-01-2021
 * @company     https://diplomasafe.com
 * @copyright   2021 Diplomasafe ApS
 */

namespace mod_diplomasafe;

use mod_diplomasafe\entities\template;
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
        $queue = new queue(factory::get_config());
        $queue->process_pending();
    }

    /**
     * @param bool $output_debug_info
     *
     * @throws \coding_exception
     * @throws \dml_exception
     * @throws \moodle_exception
     */
    public static function create_templates($output_debug_info = true) : void {
        $api_repo = template_factory::get_api_repository();
        $mapper = template_factory::get_mapper();

        $templates = $api_repo->get_all();

        $total_templates_count = count($templates);

        if ($output_debug_info) {
            mtrace(get_string('message_remote_templates_to_store', 'mod_diplomasafe', $total_templates_count));
        }

        $stored_templates_count = 0;

        $i = 1;
        foreach ($templates as $template) {
            $valid_text = get_string('message_marked_as_invalid', 'mod_diplomasafe');
            try {
                /** @var template $template */
                $mapper->store($template);
                if ($template->is_valid()) {
                    $valid_text = get_string('message_marked_as_valid', 'mod_diplomasafe');
                }
                if ($output_debug_info) {
                    mtrace(
                        $i . ') ' . get_string('message_template_stored_successfully', 'mod_diplomasafe') .
                        ' - ' . $valid_text
                    );
                }
                $stored_templates_count++;
            } catch (\Exception $e) {
                if ($output_debug_info) {
                    mtrace(
                        $i . ') ' . $e->getMessage()
                    );
                }
                throw new \RuntimeException($e->getMessage());
            }
            $i++;
        }

        if ($output_debug_info) {
            mtrace(get_string('message_remote_templates_stored', 'mod_diplomasafe', [
                'stored_count' => $stored_templates_count,
                'total_count' => $total_templates_count
            ]));
        }
    }
}
