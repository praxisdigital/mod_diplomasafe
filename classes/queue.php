<?php
/**
 * @developer   Johnny Drud
 * @date        13-01-2021
 * @company     https://diplomasafe.com
 * @copyright   2021 Diplomasafe ApS
 */

namespace mod_diplomasafe;

use coding_exception;
use core\task\manager;
use dml_exception;
use Exception;
use mod_diplomasafe\collections\queue_items;
use mod_diplomasafe\entities\diploma;
use mod_diplomasafe\entities\queue_item;
use mod_diplomasafe\factories\diploma_factory;
use mod_diplomasafe\factories\language_factory;
use mod_diplomasafe\factories\queue_factory;
use mod_diplomasafe\factories\template_factory;
use mod_diplomasafe\queue\mapper;
use mod_diplomasafe\queue\repository;
use mod_diplomasafe\task\diploma_queue;
use moodle_database;
use RuntimeException;

defined('MOODLE_INTERNAL') || die();

/**
 * Class
 *
 * @package mod_diplomasafe
 */
class queue
{
    private mapper $mapper;
    private repository $repo;
    private queue_items $pending_items;
    private config $config;

    public function __construct(
        config $config,
        ?moodle_database $db = null
    ) {
        $this->config = $config;
        $this->mapper = queue_factory::get_queue_mapper($db, $this->config);
        $this->repo = queue_factory::get_queue_repository($db, $this->config);
        $this->pending_items = $this->repo->get_pending_items();
    }

    /**
     * @param queue_item $queue_item
     *
     * @return ?int
     * @throws dml_exception
     */
    public function push(queue_item $queue_item) : ?int {
        if (!$this->is_being_processed($queue_item)) {
            return $this->mapper->create($queue_item);
        }
        return null;
    }

    /**
     * @param queue_item $queue_item
     *
     * @return bool
     * @throws dml_exception
     */
    private function is_being_processed(queue_item $queue_item) : bool {
        return $this->repo->is_being_processed($queue_item);
    }

    /**
     * @return mixed
     */
    public function get_next(): mixed {
        return $this->pending_items->get_next();
    }

    /**
     * @return queue_item|bool
     */
    public function get_current(): mixed {
        return $this->pending_items->get_current();
    }

    /**
     * @param queue_item $queue_item
     * @param int $status
     * @param string $message
     *
     * @return mixed
     * @throws dml_exception
     */
    public function set_status(queue_item $queue_item, int $status, string $message = ''): bool {
        $queue_item->status = $status;
        $queue_item->message = $message;
        $queue_item->last_run = time();
        if ($status === queue_item::QUEUE_ITEM_STATUS_FAILED) {
            $queue_item->last_mail_sent = time();
        }
        return $this->mapper->update($queue_item);
    }

    /**
     * @param bool $output_exception
     *
     * @throws coding_exception
     * @throws dml_exception
     */
    public function process_pending(bool $output_exception = false) : void {

        $this->delete_expired_items();

        $i = 1;

        $amount_to_process = $this->config->get_queue_amount_to_process();
        $language_repository = language_factory::get_repository();
        mtrace(get_string('message_processing_queue_items', 'mod_diplomasafe'));

        $amount_processed = 0;
        do {
            $queue_item = $this->get_current();
            if ($queue_item === false) {
                break;
            }
            try {
                if ($i > $amount_to_process && $amount_to_process !== 0) {
                    break;
                }
                $template_repository = template_factory::get_repository();
                $template = $template_repository->get_by_id($queue_item->template_id);

                $diploma = new diploma([
                    'template' => $template,
                    'course_id' => $queue_item->course_id,
                    'module_instance_id' => $queue_item->module_instance_id,
                    'user_id' => $queue_item->user_id,
                    'issue_date' => date('Y-m-d'),
                    'language' => $language_repository->get_by_id($template->default_language_id)
                ]);

                $diploma_mapper = diploma_factory::get_api_mapper();
                $diploma_mapper->create($diploma);
                $this->set_status($queue_item, queue_item::QUEUE_ITEM_STATUS_SUCCESSFUL);
                mtrace(
                    get_string('message_item_number', 'mod_diplomasafe', $i)
                    . get_string('message_diploma_created_successfully', 'mod_diplomasafe', [
                        'course_id' => $queue_item->course_id,
                        'module_instance_id' => $queue_item->module_instance_id,
                        'user_id' => $queue_item->user_id,
                    ])
                );
            } catch (Exception $e) {
                mtrace(get_string('message_item_number', 'mod_diplomasafe', $i) . $e->getMessage());
                $admin_task_mailer = new admin_task_mailer($queue_item->course_id);
                $admin_task_mailer->send_to_all($e->getMessage());
                $this->set_status($queue_item, queue_item::QUEUE_ITEM_STATUS_FAILED, $e->getMessage());

                $this->retry_failed_item($queue_item);

                if ($output_exception) {
                    throw new RuntimeException($e->getMessage());
                }
            }
            $i++;
            $amount_processed++;
        } while ($this->get_next());

        mtrace(get_string('message_total_queue_items_processed', 'mod_diplomasafe', $amount_processed));
    }

    /**
     * @return bool
     * @throws coding_exception
     * @throws dml_exception
     */
    public function delete_expired_items() : bool {
        return $this->mapper->delete_many($this->repo->get_expired_items());
    }

    private function retry_failed_item(queue_item $item): void {

        if ($item->status !== queue_item::QUEUE_ITEM_STATUS_FAILED) {
            return;
        }

        $task = diploma_queue::create_by_queue_id($item->id);
        // Set the next run time to 5 minutes from now
        $task->set_next_run_time(time() + 300);

        manager::queue_adhoc_task($task, true);
    }
}
