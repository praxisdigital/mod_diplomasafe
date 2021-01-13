<?php
/**
 * @developer   Johnny Drud
 * @date        13-01-2021
 * @company     https://diplomasafe.com
 * @copyright   2021 Diplomasafe ApS
 */

namespace mod_diplomasafe\queue;

use mod_diplomasafe\collections\queue_items;
use mod_diplomasafe\entities\queue_item;

defined('MOODLE_INTERNAL') || die();

/**
 * Class
 *
 * @package mod_diplomasafe\queue
 */
class repository
{
    /**
     * @const string
     */
    private const TABLE = 'diplomasafe_queue';

    /**
     * @var \moodle_database
     */
    private $db;

    /**
     * Constructor
     *
     * @param \moodle_database $db
     */
    public function __construct(\moodle_database $db) {
        $this->db = $db;
    }

    /**
     * @param queue_item $queue_item
     *
     * @return bool
     * @throws \dml_exception
     */
    public function is_being_processed(queue_item $queue_item): bool {
        $sql = /** @lang mysql */'
        SELECT id
        FROM {' . self::TABLE . '}
        WHERE course_id = :course_id AND user_id = :user_id AND
        status != :status_pending && status != :status_running
        ';
        return $this->db->record_exists_sql($sql, [
            'course_id' => $queue_item->course_id,
            'user_id' => $queue_item->user_id,
            'status_pending' => queue_item::QUEUE_ITEM_STATUS_PENDING,
            'status_running' => queue_item::QUEUE_ITEM_STATUS_RUNNING
        ]);
    }

    /**
     * @return queue_items
     * @throws \dml_exception
     */
    public function get_pending_items() : queue_items {
        $sql = /** @lang mysql */'
        SELECT *
        FROM {' . self::TABLE . '}
        WHERE status = :status_pending
        ORDER BY id
        ';
        $records = $this->db->get_records_sql($sql, [
            'status_pending' => queue_item::QUEUE_ITEM_STATUS_PENDING
        ]);

        if (empty($records)) {
            return new queue_items([]);
        }

        $pending_items = [];
        foreach ($records as $record) {
            $pending_items[] = new queue_item((array)$record);
        }

        return new queue_items($pending_items);
    }
}
