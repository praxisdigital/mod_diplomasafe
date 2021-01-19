<?php
/**
 * @developer   Johnny Drud
 * @date        13-01-2021
 * @company     https://diplomasafe.com
 * @copyright   2021 Diplomasafe ApS
 */

namespace mod_diplomasafe\collections;

use mod_diplomasafe\collection;
use mod_diplomasafe\entities\queue_item;

defined('MOODLE_INTERNAL') || die();

/**
 * Class
 *
 * @package mod_diplomasafe\collections
 */
class queue_items extends collection
{
    /**
     * Constructor
     *
     * @param $queue_items
     *
     * @throws \coding_exception
     */
    public function __construct($queue_items) {
        $queue_items = $this->format($queue_items);
        $this->set($queue_items);
    }

    /**
     * @param $queue_items
     *
     * @return mixed
     * @throws \coding_exception
     */
    private function format($queue_items) {
        foreach ($queue_items as $i => $queue_item) {
            /** @var queue_item $queue_item */

            $timestamp_fields = ['time_created', 'time_modified', 'last_run', 'last_mail_sent'];
            $queue_item = $this->format_timestamp_fields($queue_item, $timestamp_fields);

            $queue_item->status_item = queue_item::status_to_array($queue_item->status);
            $queue_item->allow_readd = false;
            if ((int)$queue_item->status === queue_item::QUEUE_ITEM_STATUS_FAILED) {
                $queue_item->allow_readd = true;
            }

            $queue_items[$i] = $queue_item;
        }
        return $queue_items;
    }

    /**
     * @param $item
     * @param $timestamp_fields
     *
     * @return mixed
     */
    private function format_timestamp_fields($item, $timestamp_fields) {
        foreach ($timestamp_fields as $timestamp_field) {
            $field_formatted = '';
            if ((int)$item->{$timestamp_field} !== 0) {
                $field_formatted = (new \DateTime('now'))->setTimestamp($item->{$timestamp_field})
                    ->format('Y-m-d H:i:s');
            }
            $item->{$timestamp_field . '_formatted'} = $field_formatted;
        }
        return $item;
    }

    /**
     * @return queue_item|bool
     */
    public function get_next() {
        return next($this->data);
    }

    /**
     * @return queue_item|bool
     */
    public function get_current() {
        return current($this->data);
    }
}
