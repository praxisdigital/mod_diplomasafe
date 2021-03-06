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
class mapper
{
    public const TABLE = 'diplomasafe_queue';

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
     * @return int
     * @throws \dml_exception
     */
    public function create(queue_item $queue_item) : int {
        $record = [
            'module_instance_id' => $queue_item->module_instance_id,
            'user_id' => $queue_item->user_id,
            'status' => $queue_item->status,
            'time_modified' => $queue_item->time_modified
        ];

        $optional_fields = [
            'time_created', 'last_run', 'last_mail_sent', 'message'
        ];

        foreach ($optional_fields as $field_code) {
            if (isset($queue_item->{$field_code})) {
                $record[$field_code] = $queue_item->{$field_code};
            }
        }

        return $this->db->insert_record(self::TABLE, (object)$record);
    }

    /**
     * @param queue_item $queue_item
     *
     * @return bool
     * @throws \dml_exception
     */
    public function update(queue_item $queue_item) : bool {

        $record = [
            'id' => $queue_item->id,
            'status' => $queue_item->status,
            'time_modified' => $queue_item->time_modified
        ];

        $optional_fields = [
            'last_run', 'last_mail_sent', 'message'
        ];

        foreach ($optional_fields as $field_code) {
            if (isset($queue_item->{$field_code})) {
                $record[$field_code] = $queue_item->{$field_code};
            }
        }

        return $this->db->update_record(self::TABLE, (object)$record);
    }

    /**
     * @param queue_item $queue_item
     *
     * @return bool
     * @throws \dml_exception
     */
    public function delete(queue_item $queue_item) : bool {
        return $this->db->delete_records(self::TABLE, [
            'id' => $queue_item->id
        ]);
    }

    /**
     * @param queue_items $queue_items
     *
     * @return bool
     * @throws \dml_exception
     */
    public function delete_many(queue_items $queue_items) : bool {
        if ($queue_items->count() === 0) {
            return true;
        }
        $ids_to_delete = [];
        foreach ($queue_items as $queue_item) {
            /** @var queue_item $queue_item */
            $ids_to_delete[] = $queue_item->id;
        }
        return $this->db->delete_records_list(self::TABLE, 'id', $ids_to_delete);
    }
}
