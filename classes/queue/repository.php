<?php
/**
 * @developer   Johnny Drud
 * @date        13-01-2021
 * @company     https://diplomasafe.com
 * @copyright   2021 Diplomasafe ApS
 */

namespace mod_diplomasafe\queue;

use mod_diplomasafe\collection;
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
        SELECT DISTINCT q.id
        FROM {' . self::TABLE . '} q
        LEFT JOIN {diplomasafe} d ON d.id = q.module_instance_id
        WHERE q.module_instance_id = :module_instance_id AND q.user_id = :user_id AND
        (q.status = :status_pending OR q.status = :status_running)
        ';
        return $this->db->record_exists_sql($sql, [
            'module_instance_id' => $queue_item->module_instance_id,
            'user_id' => $queue_item->user_id,
            'status_pending' => queue_item::QUEUE_ITEM_STATUS_PENDING,
            'status_running' => queue_item::QUEUE_ITEM_STATUS_RUNNING
        ]);
    }

    /**
     * @param array $statuses
     * @param string $order_by
     *
     * @return queue_items
     * @throws \coding_exception
     * @throws \dml_exception
     */
    public function get_all($statuses = [], $order_by = 'id DESC') : queue_items {

        $sql = /** @lang mysql */'
        SELECT DISTINCT q.*, concat(u.firstname, \' \' , u.lastname) user_fullname, 
        d.name module_instance_name, c.fullname course_fullname 
        FROM {' . self::TABLE . '} q
        LEFT JOIN {diplomasafe} d ON d.id = q.module_instance_id
        LEFT JOIN {course} c ON c.id = d.course
        LEFT JOIN {user} u ON u.id = q.user_id
        WHERE 1 ';

        $sql_params = [];
        if (!empty($statuses)) {
            [$in_sql, $sql_params] = $this->db->get_in_or_equal(array_values($statuses), SQL_PARAMS_NAMED);
            $sql .= 'AND q.status ' . $in_sql;
        }

        $sql .= 'ORDER BY q.' . $order_by;

        $records = $this->db->get_records_sql($sql, $sql_params);

        if (empty($records)) {
            return new queue_items([]);
        }

        $pending_items = [];
        foreach ($records as $record) {
            $pending_items[] = new queue_item((array)$record);
        }

        return new queue_items($pending_items);
    }

    /**
     * @return queue_items
     * @throws \dml_exception
     * @throws \coding_exception
     */
    public function get_pending_items() : queue_items {
        return $this->get_all([queue_item::QUEUE_ITEM_STATUS_PENDING], 'id ASC');
    }

    /**
     * @param int $item_id
     *
     * @return queue_item
     * @throws \dml_exception
     */
    public function get_by_id(int $item_id) : queue_item {
        return new queue_item((array)$this->db->get_record(self::TABLE, [
            'id' => $item_id
        ]));
    }
}
