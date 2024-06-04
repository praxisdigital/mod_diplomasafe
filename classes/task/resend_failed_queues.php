<?php
// This file is part of Moodle - https://moodle.org/
//
// Moodle is free software: you can redistribute it and/or modify
// it under the terms of the GNU General Public License as published by
// the Free Software Foundation, either version 3 of the License, or
// (at your option) any later version.
//
// Moodle is distributed in the hope that it will be useful,
// but WITHOUT ANY WARRANTY; without even the implied warranty of
// MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
// GNU General Public License for more details.
//
// You should have received a copy of the GNU General Public License
// along with Moodle.  If not, see <https://www.gnu.org/licenses/>.

/**
 * Plugin version and other meta-data are defined here.
 *
 * @package     mod_diplomasafe
 * @copyright   2020 Diplomasafe <info@diplomasafe.com>
 * @license     https://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */

namespace mod_diplomasafe\task;

use mod_diplomasafe\collections\queue_items;
use mod_diplomasafe\factories\queue_factory;
use mod_diplomasafe\queue\repository;

// @codeCoverageIgnoreStart
defined('MOODLE_INTERNAL') || die();

// @codeCoverageIgnoreEnd

class resend_failed_queues extends base_scheduled_task
{
    protected ?repository $repo = null;

    private function repository(): repository
    {
        return $this->repo ??= queue_factory::get_queue_repository();
    }

    private function get_failed_queues(): queue_items
    {
        return $this->repository()->get_failed_items();
    }

    public function get_name(): string
    {
        return get_string(
            'resend_failed_queues',
            'mod_diplomasafe'
        );
    }

    public function execute(): void
    {
        $this->output('Resending failed queues');

        $items = $this->get_failed_queues();
        $count = count($items);

        $this->output("Found $count failed items");

        if ($count === 0) {
            $this->output('Exiting, no failed items found');
            return;
        }

        foreach ($items as $item) {
            $task = diploma_queue::create_by_queue_id($item->id);
            $task->set_output_emitter($this->emitter());
            $this->enqueue_adhoc_task($task);
        }

        $this->output('Done, all resend tasks has been added to the adhoc task queue');
    }
}
